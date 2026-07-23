/**
 * Image upload compressor for Livewire / Summernote forms.
 * Resizes selected images to at most 700 KB (prefer not below 400 KB when compressing),
 * shows the upload size before/while Livewire uploads, and never blocks Livewire uploads.
 */
(function (window, document) {
    'use strict';

    var MIN_BYTES = 400 * 1024;
    var MAX_BYTES = 700 * 1024;
    var MAX_DIMENSION = 1920;
    var OUTPUT_TYPE = 'image/jpeg';
    var lastSizeByInput = {};
    var processing = new WeakSet();
    var booted = false;

    function formatBytes(bytes) {
        if (!bytes && bytes !== 0) return '—';
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
    }

    function isImageFile(file) {
        if (!file) return false;
        if (file.type && file.type.indexOf('image/') === 0) return true;
        return /\.(jpe?g|png|gif|webp|bmp)$/i.test(file.name || '');
    }

    function inputAcceptsImages(input) {
        if (!(input instanceof HTMLInputElement) || input.type !== 'file') return false;
        if (input.hasAttribute('data-skip-image-compress')) return false;
        var accept = (input.getAttribute('accept') || '').toLowerCase();
        if (!accept) return false;
        if (accept.indexOf('image') !== -1) return true;
        return /\.?(jpe?g|png|gif|webp|bmp)/.test(accept);
    }

    function inputKey(input) {
        return getWireModelName(input) || input.name || input.id || '';
    }

    function getWireModelName(input) {
        if (!input || !input.attributes) return null;
        for (var i = 0; i < input.attributes.length; i++) {
            var attr = input.attributes[i];
            if (attr.name === 'wire:model' || attr.name.indexOf('wire:model.') === 0) {
                return attr.value;
            }
        }
        return null;
    }

    function getLivewireComponent(input) {
        if (!window.Livewire || typeof Livewire.find !== 'function') return null;
        var el = input.closest('[wire\\:id]');
        if (!el) return null;
        try {
            return Livewire.find(el.getAttribute('wire:id'));
        } catch (e) {
            return null;
        }
    }

    function loadImage(file) {
        return new Promise(function (resolve, reject) {
            var url = URL.createObjectURL(file);
            var img = new Image();
            img.onload = function () {
                URL.revokeObjectURL(url);
                resolve(img);
            };
            img.onerror = function () {
                URL.revokeObjectURL(url);
                reject(new Error('Could not read image'));
            };
            img.src = url;
        });
    }

    function canvasToBlob(canvas, type, quality) {
        return new Promise(function (resolve) {
            canvas.toBlob(function (blob) {
                resolve(blob);
            }, type, quality);
        });
    }

    function drawScaled(img, maxDim) {
        var w = img.naturalWidth || img.width;
        var h = img.naturalHeight || img.height;
        var scale = 1;
        if (w > maxDim || h > maxDim) {
            scale = Math.min(maxDim / w, maxDim / h);
        }
        var cw = Math.max(1, Math.round(w * scale));
        var ch = Math.max(1, Math.round(h * scale));
        var canvas = document.createElement('canvas');
        canvas.width = cw;
        canvas.height = ch;
        var ctx = canvas.getContext('2d');
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, cw, ch);
        ctx.drawImage(img, 0, 0, cw, ch);
        return canvas;
    }

    async function compressImageFile(file) {
        var originalSize = file.size;

        if (!isImageFile(file)) {
            return { file: file, originalSize: originalSize, finalSize: originalSize, compressed: false };
        }

        if (originalSize <= MAX_BYTES) {
            return { file: file, originalSize: originalSize, finalSize: originalSize, compressed: false };
        }

        var img;
        try {
            img = await loadImage(file);
        } catch (e) {
            return { file: file, originalSize: originalSize, finalSize: originalSize, compressed: false, error: e.message };
        }

        var dimensions = [MAX_DIMENSION, 1600, 1280, 1024, 800];
        var bestBlob = null;

        for (var d = 0; d < dimensions.length; d++) {
            var canvas = drawScaled(img, dimensions[d]);
            var low = 0.45;
            var high = 0.92;
            var candidate = null;

            for (var i = 0; i < 8; i++) {
                var quality = (low + high) / 2;
                var blob = await canvasToBlob(canvas, OUTPUT_TYPE, quality);
                if (!blob) break;

                if (blob.size > MAX_BYTES) {
                    high = quality;
                    continue;
                }

                candidate = blob;

                if (blob.size < MIN_BYTES) {
                    low = quality;
                } else {
                    bestBlob = blob;
                    break;
                }
            }

            if (bestBlob && bestBlob.size >= MIN_BYTES && bestBlob.size <= MAX_BYTES) {
                break;
            }

            if (candidate && (!bestBlob || Math.abs(candidate.size - MAX_BYTES) < Math.abs(bestBlob.size - MAX_BYTES))) {
                bestBlob = candidate;
            }

            if (!candidate) {
                var forced = await canvasToBlob(canvas, OUTPUT_TYPE, 0.45);
                if (forced && forced.size <= MAX_BYTES) {
                    bestBlob = forced;
                    if (forced.size >= MIN_BYTES) break;
                } else if (forced && (!bestBlob || forced.size < bestBlob.size)) {
                    bestBlob = forced;
                }
            }
        }

        if (!bestBlob || bestBlob.size >= originalSize) {
            return { file: file, originalSize: originalSize, finalSize: originalSize, compressed: false };
        }

        var baseName = (file.name || 'image').replace(/\.[^.]+$/, '');
        var compressedFile = new File([bestBlob], baseName + '.jpg', {
            type: OUTPUT_TYPE,
            lastModified: Date.now()
        });

        return {
            file: compressedFile,
            originalSize: originalSize,
            finalSize: compressedFile.size,
            compressed: true
        };
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function renderSizeInfo(panel, results, status) {
        if (!panel) return;

        if (status === 'working') {
            panel.innerHTML = '<span style="color:#0d6efd;">Optimizing image…</span>';
            return;
        }

        if (!results || !results.length) {
            panel.innerHTML = '<span style="color:#6c757d;">Images are optimized to 400–700 KB before upload. You will see the size here after selecting a file.</span>';
            return;
        }

        var html = results.map(function (r, idx) {
            var name = r.file && r.file.name ? r.file.name : ('Image ' + (idx + 1));
            var line;
            if (r.error) {
                line = '<span style="color:#dc3545;">' + escapeHtml(name) + ': could not optimize — uploading original (' + formatBytes(r.originalSize) + ').</span>';
            } else if (r.compressed) {
                line = '<strong>' + escapeHtml(name) + '</strong>: original <strong>' + formatBytes(r.originalSize) + '</strong> → upload size <strong style="color:#198754;">' + formatBytes(r.finalSize) + '</strong>';
            } else {
                line = '<strong>' + escapeHtml(name) + '</strong>: upload size <strong style="color:#198754;">' + formatBytes(r.finalSize) + '</strong>';
                if (r.finalSize > MAX_BYTES) {
                    line += ' <span style="color:#fd7e14;">(above 700 KB — could not compress further)</span>';
                } else if (r.finalSize < MIN_BYTES) {
                    line += ' <span style="color:#6c757d;">(under 400 KB — kept as-is)</span>';
                }
            }
            return '<div>' + line + '</div>';
        }).join('');

        panel.innerHTML = html;
    }

    function ensureSizePanel(input) {
        if (!input || !input.parentElement) return null;

        var key = inputKey(input);
        var panel = input.nextElementSibling;
        if (panel && panel.getAttribute && panel.getAttribute('data-image-size-panel') === '1') {
            if (lastSizeByInput[key]) {
                renderSizeInfo(panel, lastSizeByInput[key], 'done');
            }
            return panel;
        }

        var siblings = input.parentElement.querySelectorAll('[data-image-size-panel="1"]');
        for (var i = 0; i < siblings.length; i++) {
            if (siblings[i].dataset.forInput === key) {
                if (lastSizeByInput[key]) {
                    renderSizeInfo(siblings[i], lastSizeByInput[key], 'done');
                }
                return siblings[i];
            }
        }

        panel = document.createElement('div');
        panel.setAttribute('data-image-size-panel', '1');
        panel.dataset.forInput = key;
        panel.className = 'image-upload-size-info small mt-1';
        if (lastSizeByInput[key]) {
            renderSizeInfo(panel, lastSizeByInput[key], 'done');
        } else {
            panel.innerHTML = '<span style="color:#6c757d;">Images are optimized to 400–700 KB before upload. You will see the size here after selecting a file.</span>';
        }
        input.insertAdjacentElement('afterend', panel);
        return panel;
    }

    function rememberResults(input, results) {
        lastSizeByInput[inputKey(input)] = results.map(function (r) {
            return {
                file: { name: r.file.name },
                originalSize: r.originalSize,
                finalSize: r.finalSize,
                compressed: r.compressed,
                error: r.error || null
            };
        });
    }

    function showSizesForRawFiles(input, files) {
        var results = files.map(function (file) {
            return { file: file, originalSize: file.size, finalSize: file.size, compressed: false };
        });
        rememberResults(input, results);
        renderSizeInfo(ensureSizePanel(input), results, 'done');
    }

    function uploadToLivewire(input, files) {
        var component = getLivewireComponent(input);
        var prop = getWireModelName(input);
        if (!component || !prop || !files.length) return false;

        var wire = component.$wire || component;
        var uploadFn = null;
        var uploadMultipleFn = null;

        if (wire && typeof wire.upload === 'function') {
            uploadFn = wire.upload.bind(wire);
            uploadMultipleFn = typeof wire.uploadMultiple === 'function' ? wire.uploadMultiple.bind(wire) : null;
        } else if (typeof component.upload === 'function') {
            uploadFn = component.upload.bind(component);
            uploadMultipleFn = typeof component.uploadMultiple === 'function' ? component.uploadMultiple.bind(component) : null;
        }

        if (!uploadFn) return false;

        var onError = function (err) {
            console.error('Livewire image upload failed', err);
            var panel = ensureSizePanel(input);
            if (panel) {
                panel.innerHTML = '<span style="color:#dc3545;">Upload failed. Please try again.</span>';
            }
        };

        try {
            if (input.multiple && uploadMultipleFn) {
                uploadMultipleFn(prop, files, function () {}, onError);
            } else {
                uploadFn(prop, files[0], function () {}, onError);
            }
            return true;
        } catch (e) {
            console.error(e);
            return false;
        }
    }

    function replaceInputFilesAndDispatch(input, files) {
        var dt = new DataTransfer();
        for (var i = 0; i < files.length; i++) {
            dt.items.add(files[i]);
        }
        input.files = dt.files;
        input.dataset.imageCompressReady = '1';
        input.dispatchEvent(new Event('change', { bubbles: true }));
        setTimeout(function () {
            delete input.dataset.imageCompressReady;
        }, 0);
    }

    async function onFileChange(event) {
        var input = event.target;
        if (!inputAcceptsImages(input)) return;
        if (input.dataset.imageCompressReady === '1') return;
        if (!input.files || !input.files.length) return;

        var files = Array.prototype.slice.call(input.files);
        var hasImage = files.some(isImageFile);
        if (!hasImage) return;

        var needsCompress = files.some(function (file) {
            return isImageFile(file) && file.size > MAX_BYTES;
        });

        // Small images: do not block Livewire — only show the size.
        if (!needsCompress) {
            showSizesForRawFiles(input, files);
            return;
        }

        event.stopImmediatePropagation();
        event.preventDefault();

        if (processing.has(input)) return;
        processing.add(input);

        var panel = ensureSizePanel(input);
        renderSizeInfo(panel, null, 'working');

        try {
            var results = [];
            var outFiles = [];

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (!isImageFile(file) || file.size <= MAX_BYTES) {
                    results.push({ file: file, originalSize: file.size, finalSize: file.size, compressed: false });
                    outFiles.push(file);
                    continue;
                }
                var result = await compressImageFile(file);
                results.push(result);
                outFiles.push(result.file);
            }

            rememberResults(input, results);
            renderSizeInfo(panel, results, 'done');

            if (!uploadToLivewire(input, outFiles)) {
                replaceInputFilesAndDispatch(input, outFiles);
            }
        } catch (err) {
            console.error('Image compress failed', err);
            if (panel) {
                panel.innerHTML = '<span style="color:#dc3545;">Optimization failed. Uploading original file.</span>';
            }
            if (!uploadToLivewire(input, files)) {
                replaceInputFilesAndDispatch(input, files);
            }
        } finally {
            processing.delete(input);
        }
    }

    function bindHintPanels() {
        document.querySelectorAll('input[type="file"]').forEach(function (input) {
            if (!inputAcceptsImages(input)) return;
            ensureSizePanel(input);
        });
    }

    function boot() {
        if (booted) return;
        booted = true;

        document.addEventListener('change', onFileChange, true);
        bindHintPanels();

        document.addEventListener('livewire:init', function () {
            if (window.Livewire && typeof Livewire.hook === 'function') {
                Livewire.hook('message.processed', function () {
                    bindHintPanels();
                });
            }
        });

        if (window.Livewire && typeof Livewire.hook === 'function') {
            Livewire.hook('message.processed', function () {
                bindHintPanels();
            });
        }

        document.addEventListener('livewire:navigated', bindHintPanels);
    }

    window.KnlcaImageUpload = {
        minBytes: MIN_BYTES,
        maxBytes: MAX_BYTES,
        formatBytes: formatBytes,
        compressImageFile: compressImageFile,
        compressFiles: async function (fileList) {
            var files = Array.prototype.slice.call(fileList || []);
            var out = [];
            for (var i = 0; i < files.length; i++) {
                out.push(await compressImageFile(files[i]));
            }
            return out;
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})(window, document);
