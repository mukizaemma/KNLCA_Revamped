<div>
    <x-page-locator title="Gallery" :header="$header" />
    <div class="content page-wrap">
        @php
            $g = $siteContent['gallery'] ?? [];
            $lightboxJson = json_encode(
                $galleryLightboxImages instanceof \Illuminate\Support\Collection
                    ? $galleryLightboxImages->values()->all()
                    : $galleryLightboxImages,
                JSON_UNESCAPED_SLASHES
            );
        @endphp

        <div class="gallery-page"
             data-images="{{ $lightboxJson ?: '[]' }}"
             x-data="{
                lightboxOpen: false,
                lightboxIndex: 0,
                images: [],
                init() {
                    try {
                        this.images = JSON.parse(this.$el.getAttribute('data-images') || '[]');
                    } catch (e) {
                        this.images = [];
                    }
                    if (!Array.isArray(this.images)) this.images = [];
                },
                openLightbox(idx) {
                    if (!this.images.length) return;
                    this.lightboxIndex = Number(idx) || 0;
                    this.lightboxOpen = true;
                    document.body.style.overflow = 'hidden';
                },
                closeLightbox() {
                    this.lightboxOpen = false;
                    document.body.style.overflow = '';
                },
                nextImage() {
                    if (this.images.length < 2) return;
                    this.lightboxIndex = (this.lightboxIndex + 1) % this.images.length;
                },
                prevImage() {
                    if (this.images.length < 2) return;
                    this.lightboxIndex = (this.lightboxIndex - 1 + this.images.length) % this.images.length;
                }
             }"
             @keydown.escape.window="if (lightboxOpen) closeLightbox()"
             @keydown.arrow-left.window="if (lightboxOpen) prevImage()"
             @keydown.arrow-right.window="if (lightboxOpen) nextImage()">

            <div class="section-header">
                <p class="section-heading">{{ $g['section_label'] ?? 'Gallery' }}</p>
                <h2 class="section-title">{{ $g['section_title'] ?? 'Life at our school' }}</h2>
                @if(!empty($g['section_subtitle']))
                    <p class="section-sub section-sub--center">{{ $g['section_subtitle'] }}</p>
                @endif
            </div>

            @if($items->isEmpty())
                <p class="text-muted" style="text-align:center;">{{ $g['empty'] ?? 'No gallery items yet.' }}</p>
            @else
                <div class="gallery-grid">
                    @foreach($items as $idx => $item)
                        <button type="button"
                                class="gallery-item"
                                @click="openLightbox({{ (int) $idx }})"
                                aria-label="Open {{ $item->title ?: 'image' }} {{ $idx + 1 }} of {{ $items->count() }}">
                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->title ?? 'Gallery' }}" loading="lazy">
                            @if($item->title || $item->caption)
                                <span class="gallery-caption">
                                    @if($item->title)<strong>{{ $item->title }}</strong>@endif
                                    @if($item->caption)<span>{{ \Illuminate\Support\Str::limit(strip_tags($item->caption), 60) }}</span>@endif
                                </span>
                            @endif
                        </button>
                    @endforeach
                </div>

                <template x-teleport="body">
                    <div class="gallery-lightbox"
                         x-show="lightboxOpen"
                         x-cloak
                         x-transition.opacity
                         @click.self="closeLightbox()"
                         role="dialog"
                         aria-modal="true"
                         :aria-hidden="(!lightboxOpen).toString()"
                         :aria-label="'Image ' + (lightboxIndex + 1) + ' of ' + images.length">
                        <button type="button" class="gallery-lightbox__close" @click="closeLightbox()" aria-label="Close">&times;</button>
                        <button type="button"
                                class="gallery-lightbox__arrow gallery-lightbox__arrow--prev"
                                @click.stop="prevImage()"
                                aria-label="Previous image"
                                x-show="images.length > 1">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="32" height="32"><path d="M15 18l-6-6 6-6"/></svg>
                        </button>
                        <div class="gallery-lightbox__content" @click.stop>
                            <img class="gallery-lightbox__img"
                                 :src="images[lightboxIndex] ? images[lightboxIndex].src : ''"
                                 :alt="images[lightboxIndex] ? images[lightboxIndex].alt : 'Gallery'">
                            <p class="gallery-lightbox__title"
                               x-show="images[lightboxIndex] && images[lightboxIndex].title"
                               x-text="images[lightboxIndex] ? images[lightboxIndex].title : ''"></p>
                            <p class="gallery-lightbox__caption"
                               x-show="images[lightboxIndex] && images[lightboxIndex].caption"
                               x-text="images[lightboxIndex] ? images[lightboxIndex].caption : ''"></p>
                        </div>
                        <button type="button"
                                class="gallery-lightbox__arrow gallery-lightbox__arrow--next"
                                @click.stop="nextImage()"
                                aria-label="Next image"
                                x-show="images.length > 1">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="32" height="32"><path d="M9 18l6-6-6-6"/></svg>
                        </button>
                        <p class="gallery-lightbox__counter" x-text="(lightboxIndex + 1) + ' / ' + images.length"></p>
                    </div>
                </template>
            @endif
        </div>
    </div>
</div>
