<div>
<x-page-locator title="Gallery" :header="$header" />
<div class="content page-wrap">
    @php $galleryImages = $items->filter(fn($i) => $i->image_path)->values(); @endphp
    <div class="gallery-page" x-data="{
        lightboxOpen: false,
        lightboxIndex: 0,
        images: @json($galleryImages->map(fn($i) => ['src' => asset($i->image_path), 'alt' => $i->title ?? 'Gallery', 'caption' => strip_tags($i->caption ?? '')])->values()),
        openLightbox(idx) { this.lightboxIndex = idx; this.lightboxOpen = true; },
        closeLightbox() { this.lightboxOpen = false; },
        nextImage() { this.lightboxIndex = (this.lightboxIndex + 1) % this.images.length; },
        prevImage() { this.lightboxIndex = (this.lightboxIndex - 1 + this.images.length) % this.images.length; }
    }" @keydown.escape.window="closeLightbox()" @keydown.arrow-left.window="if(lightboxOpen) prevImage()" @keydown.arrow-right.window="if(lightboxOpen) nextImage()">
        <div class="section-header">
            @php $g = $siteContent['gallery'] ?? []; @endphp
            <p class="section-heading">{{ $g['section_label'] ?? 'Gallery' }}</p>
            <h2 class="section-title">{{ $g['section_title'] ?? 'Life at our school' }}</h2>
            <p class="section-sub section-sub--center">{{ $g['section_subtitle'] ?? '' }}</p>
        </div>
        @if($galleryImages->isEmpty())
            <p class="text-muted">{{ $g['empty'] ?? 'No gallery items yet.' }}</p>
        @else
            <div class="gallery-grid">
                @foreach($galleryImages as $idx => $item)
                    <div class="gallery-item" role="button" tabindex="0" @click="openLightbox({{ $idx }})" @keydown.enter="openLightbox({{ $idx }})">
                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->title ?? 'Gallery' }}">
                            @if($item->title || $item->caption)
                                <div class="gallery-caption">
                                    @if($item->title)<strong>{{ $item->title }}</strong>@endif
                                    @if($item->caption)<span>{{ \Illuminate\Support\Str::limit(strip_tags($item->caption), 60) }}</span>@endif
                                </div>
                            @endif
                                </div>
                @endforeach
            </div>
            {{-- Lightbox --}}
            <div class="gallery-lightbox" x-show="lightboxOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:leave="transition ease-in duration-150" @click.self="closeLightbox()" role="dialog" aria-modal="true" :aria-label="'Image ' + (lightboxIndex + 1) + ' of ' + images.length">
                <button type="button" class="gallery-lightbox__close" @click="closeLightbox()" aria-label="Close">&times;</button>
                <button type="button" class="gallery-lightbox__arrow gallery-lightbox__arrow--prev" @click.stop="prevImage()" aria-label="Previous image">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="32" height="32"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <div class="gallery-lightbox__content" @click.stop>
                    <img :src="images[lightboxIndex]?.src" :alt="images[lightboxIndex]?.alt" class="gallery-lightbox__img">
                    <p class="gallery-lightbox__caption" x-show="images[lightboxIndex]?.caption" x-text="images[lightboxIndex]?.caption"></p>
                </div>
                <button type="button" class="gallery-lightbox__arrow gallery-lightbox__arrow--next" @click.stop="nextImage()" aria-label="Next image">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="32" height="32"><path d="M9 18l6-6-6-6"/></svg>
                </button>
                <p class="gallery-lightbox__counter" x-text="(lightboxIndex + 1) + ' / ' + images.length"></p>
            </div>
        @endif
    </div>
</div>
</div>
