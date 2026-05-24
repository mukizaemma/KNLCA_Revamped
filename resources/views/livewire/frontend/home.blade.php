<div>
    @push('styles')
        <link href="{{ asset('css/home.css') }}?v={{ filemtime(public_path('css/home.css')) }}" rel="stylesheet">
    @endpush

    @php
        $h = $siteContent['home'] ?? [];
        $heroPrimaryUrl = fn ($path) => str_starts_with((string) $path, 'http') ? $path : url($path);
        $hasSlides = $sliders->isNotEmpty();
        $slideList = $hasSlides ? $sliders : collect([(object)[
            'image_path' => optional($settings)->home_background_image_path,
            'title' => 'Welcome',
            'caption' => optional($settings)->company_name ?? config('app.name'),
            'button_text' => null,
            'button_url' => null,
        ]]);
        $slideCount = $slideList->count();
    @endphp
    <div class="hero-slider slider-fullwidth"
         x-data="{
             current: 0,
             total: {{ $slideCount }},
             autoplayInterval: null,
             startAutoplay() {
                 if (this.total <= 1) return;
                 this.autoplayInterval = setInterval(() => {
                     this.current = (this.current + 1) % this.total;
                 }, 6000);
             },
             stopAutoplay() { if (this.autoplayInterval) clearInterval(this.autoplayInterval); },
             next() { this.current = (this.current + 1) % this.total; this.stopAutoplay(); this.startAutoplay(); },
             prev() { this.current = (this.current - 1 + this.total) % this.total; this.stopAutoplay(); this.startAutoplay(); }
         }"
         x-init="startAutoplay()"
         @mouseenter="stopAutoplay()"
         @mouseleave="startAutoplay()">
        <div class="hero-slider__wrap">
            @foreach($slideList as $i => $slide)
                <div class="hero-slide"
                     x-show="current === {{ $i }}"
                     x-transition:enter="transition ease-out duration-800"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-600"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <div class="hero-slide__img-wrap">
                        @if($slide->image_path ?? null)
                            <img src="{{ asset($slide->image_path) }}" alt="{{ $slide->title ?? 'Slide' }}" class="hero-slide__img hero-slide__img--zoomin" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                        @else
                            <div class="hero-slide__placeholder"></div>
                        @endif
                    </div>
                    <div class="hero-slide__overlay hero-slide__overlay--bottom-shadow"></div>
                    <div class="hero-slide__content">
                        @if($slide->caption ?? $slide->title ?? null)
                            <h1 class="hero-slide__caption">{!! isset($slide->caption) && $slide->caption ? $slide->caption : e($slide->title ?? '') !!}</h1>
                        @endif
                        <div class="hero-slide__actions">
                            @php
                                $primaryText = !empty($slide->button_text) ? $slide->button_text : ($h['hero_primary_text'] ?? 'Learn about us');
                                $primaryLink = !empty($slide->button_url) ? $heroPrimaryUrl($slide->button_url) : $heroPrimaryUrl($h['hero_primary_url'] ?? '/about/inquire');
                                $secondaryText = $h['hero_secondary_text'] ?? 'Register your child';
                                $secondaryLink = $heroPrimaryUrl($h['hero_secondary_url'] ?? '/appointment');
                            @endphp
                            <a href="{{ $primaryLink }}" class="hero-slide__btn hero-slide__btn--primary" wire:navigate>
                                {{ $primaryText }}
                            </a>
                            <a href="{{ $secondaryLink }}" class="hero-slide__btn hero-slide__btn--secondary" wire:navigate>
                                {{ $secondaryText }}
                            </a>
                        </div>
                        @if(!$hasSlides && auth()->check() && auth()->user()->role !== null)
                            <a href="{{ url('/admin/sliders') }}" class="hero-slide__admin-link">Add slides in Admin</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        @if($slideCount > 1)
            <button type="button" class="hero-slider__btn hero-slider__btn--prev" @click="prev()" aria-label="Previous slide">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="28" height="28"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button type="button" class="hero-slider__btn hero-slider__btn--next" @click="next()" aria-label="Next slide">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="28" height="28"><path d="M9 18l6-6-6-6"/></svg>
            </button>
            <div class="hero-slider__dots">
                @foreach($slideList as $i => $slide)
                    <button type="button" class="hero-slider__dot" :class="{ 'hero-slider__dot--active': current === {{ $i }} }" @click="current = {{ $i }}; stopAutoplay(); startAutoplay();" aria-label="Go to slide {{ $i + 1 }}"></button>
                @endforeach
            </div>
        @endif
    </div>

    <div class="content">
        {{-- School overview --}}
        <section class="welcome-block" id="overview" aria-labelledby="home-overview-title">
            <h2 id="home-overview-title" class="welcome-block__title section-title">Welcome to {{ optional($settings)->company_name ?? 'Our School' }}</h2>
            @if($settings && $settings->home_background_text)
                <div class="welcome-block__desc lead">{!! $settings->home_background_text !!}</div>
            @else
                <p class="welcome-block__desc lead">{{ $h['overview_fallback'] ?? '' }}</p>
            @endif
            <p style="text-align:center;margin-top:20px;">
                <a href="{{ route('about') }}" class="btn-outline" wire:navigate>{{ $h['overview_link_text'] ?? 'Read more about us' }}</a>
            </p>
        </section>

        {{-- Curriculum overview --}}
        <section class="ace-strip" id="curriculum" aria-labelledby="ace-strip-title">
            <div class="ace-strip__inner">
                <div class="ace-strip__intro">
                    <p class="section-heading" style="color: var(--primary);">{{ $h['curriculum_label'] ?? 'Curriculum overview' }}</p>
                    <h2 id="ace-strip-title">{{ $h['curriculum_title'] ?? 'Accredited ACE Curriculum' }}</h2>
                    <p>{{ $h['curriculum_intro'] ?? '' }}</p>
                </div>
                <div class="ace-pillars">
                    @foreach($h['curriculum_pillars'] ?? [] as $pillar)
                        <article class="ace-pillar">
                            <div class="ace-pillar__icon" aria-hidden="true">
                                <svg viewBox="0 0 48 48" fill="none"><path d="M24 4L6 14v20l18 10 18-10V14L24 4z" stroke="currentColor" stroke-width="2"/></svg>
                            </div>
                            @if(!empty($pillar['title']))
                                <h3>{{ $pillar['title'] }}</h3>
                            @endif
                            @if(!empty($pillar['description']))
                                <p>{{ $pillar['description'] }}</p>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Programs --}}
        @if($departments->isNotEmpty())
            <section class="programs-section" id="programs" aria-labelledby="home-programs-title">
                <div class="section-header">
                    <p class="section-heading">{{ $h['programs_label'] ?? 'Programs' }}</p>
                    <h2 id="home-programs-title" class="section-title">{{ $h['programs_title'] ?? 'Nursery & Primary Programs' }}</h2>
                    <p class="section-sub section-sub--center">{{ $h['programs_subtitle'] ?? '' }}</p>
                </div>
                <div class="programs-grid programs-grid--two">
                    @foreach($departments as $i => $department)
                        @php $accent = $i % 3; @endphp
                        <a href="{{ route('departments.show', ['department' => $department->slug ?: $department->id]) }}" class="program-card program-card--{{ $accent }}" wire:navigate>
                            <div class="program-card__img-wrap">
                                @if($department->cover_image)
                                    <img src="{{ asset($department->cover_image) }}" alt="{{ $department->name }}" class="program-card__img">
                                @else
                                    <div class="program-card__placeholder"></div>
                                @endif
                            </div>
                            <h3 class="program-card__title">{{ $department->name }}</h3>
                            <p class="program-card__desc">{{ \Illuminate\Support\Str::limit(strip_tags($department->description ?? ''), 100) ?: ($h['programs_card_fallback'] ?? '') }}</p>
                            <span class="program-card__btn">Learn more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
                            <span class="program-card__line"></span>
                        </a>
                    @endforeach
                </div>
                @if($departments->count() > 2)
                <div class="programs-footer">
                    <a href="{{ route('departments.index') }}" class="btn-primary" wire:navigate>{{ $h['programs_link_text'] ?? 'View all programs' }}</a>
                </div>
                @endif
            </section>
        @endif

        {{-- Why choose us --}}
        <section class="about-values home-why-choose" id="why-choose" aria-labelledby="why-choose-title">
            <div class="section-header">
                <p class="section-heading">{{ $h['why_choose_label'] ?? 'Why choose us' }}</p>
                <h2 id="why-choose-title" class="section-title">{{ optional($settings)->about_values_subheading ?? 'Growing hearts and minds through ACE' }}</h2>
            </div>
            @if(!empty($whyChooseCards))
                <div class="values-grid">
                    @foreach($whyChooseCards as $card)
                        <div class="value-card">
                            <div class="value-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="value-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            @if(!empty($card['name']))
                                <h3 class="value-title">{{ $card['name'] }}</h3>
                            @endif
                            @if(!empty($card['description']))
                                <p class="value-desc">{{ $card['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="lead text-muted" style="text-align:center;max-width:36rem;margin:0 auto;">{{ $h['why_choose_empty'] ?? '' }}</p>
            @endif
        </section>
    </div>

    {{-- Gallery preview --}}
    @php
        $g = $siteContent['gallery'] ?? [];
        $galleryLink = ($settings->gallery_external_url ?? null)
            ? $settings->gallery_external_url
            : route('gallery.index');
        $galleryLinkExternal = (bool) ($settings->gallery_external_url ?? null);
    @endphp
    <section class="home-gallery" id="gallery" aria-labelledby="home-gallery-title">
        <div class="content">
            <div class="home-gallery__header">
                <div>
                    <p class="section-heading">{{ $h['news_label'] ?? ($g['section_label'] ?? 'Gallery') }}</p>
                    <h2 id="home-gallery-title" class="section-title" style="margin:0;">{{ $h['news_title'] ?? ($g['section_title'] ?? 'Life at our school') }}</h2>
                    @if(!empty($g['section_subtitle']))
                        <p class="section-sub" style="margin-top:8px;margin-bottom:0;">{{ $g['section_subtitle'] }}</p>
                    @endif
                </div>
                @if($galleryImages->isNotEmpty())
                    @if($galleryLinkExternal)
                        <a href="{{ $galleryLink }}" class="home-gallery__link btn-outline" target="_blank" rel="noopener noreferrer">
                            {{ $h['news_link_text'] ?? 'View full gallery' }}
                        </a>
                    @else
                        <a href="{{ $galleryLink }}" class="home-gallery__link btn-outline" wire:navigate>
                            {{ $h['news_link_text'] ?? 'View full gallery' }}
                        </a>
                    @endif
                @endif
            </div>

            @if($galleryImages->isNotEmpty())
                <div class="home-gallery__wrap"
                     x-data="{
                         lightboxOpen: false,
                         lightboxIndex: 0,
                         images: @json($galleryImages->map(fn($i) => [
                             'src' => asset($i->image_path),
                             'alt' => $i->title ?? 'Gallery',
                             'caption' => strip_tags($i->caption ?? ''),
                         ])->values()),
                         openLightbox(idx) { this.lightboxIndex = idx; this.lightboxOpen = true; document.body.style.overflow = 'hidden'; },
                         closeLightbox() { this.lightboxOpen = false; document.body.style.overflow = ''; },
                         nextImage() { this.lightboxIndex = (this.lightboxIndex + 1) % this.images.length; },
                         prevImage() { this.lightboxIndex = (this.lightboxIndex - 1 + this.images.length) % this.images.length; }
                     }"
                     @keydown.escape.window="if (lightboxOpen) closeLightbox()"
                     @keydown.arrow-left.window="if (lightboxOpen) prevImage()"
                     @keydown.arrow-right.window="if (lightboxOpen) nextImage()">
                    <div class="home-gallery__grid">
                        @foreach($galleryImages as $idx => $item)
                            <button type="button" class="home-gallery__item" @click="openLightbox({{ $idx }})" aria-label="Open image {{ $idx + 1 }} of {{ $galleryImages->count() }}">
                                <img src="{{ asset($item->image_path) }}" alt="{{ $item->title ?? 'Gallery photo' }}" loading="lazy">
                                @if($item->title)
                                    <span class="home-gallery__item-label">{{ $item->title }}</span>
                                @endif
                            </button>
                        @endforeach
                    </div>

                    <div class="gallery-lightbox" x-show="lightboxOpen" x-cloak x-transition.opacity @click.self="closeLightbox()" role="dialog" aria-modal="true" :aria-label="'Image ' + (lightboxIndex + 1) + ' of ' + images.length">
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
                </div>
            @else
                <p class="lead text-muted" style="text-align:center;padding:24px 0;">{{ $h['news_empty'] ?? ($g['empty'] ?? 'No gallery photos yet.') }}</p>
            @endif
        </div>
    </section>
</div>
