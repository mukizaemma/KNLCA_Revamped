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
        $pillars = array_slice($h['curriculum_pillars'] ?? [], 0, 3);
        $exploreCards = $h['explore_cards'] ?? [];
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

    {{-- Curriculum overview --}}
    <section class="home-section home-curriculum" id="curriculum" aria-labelledby="ace-curriculum-title">
        <div class="content home-section__inner">
            <header class="home-section__head">
                <div class="home-section__title-row">
                    <span class="home-section__rule" aria-hidden="true"></span>
                    <h2 id="ace-curriculum-title" class="home-section__title">{{ $h['curriculum_title'] ?? 'ACE Curriculum' }}</h2>
                    <span class="home-section__rule" aria-hidden="true"></span>
                </div>
                <p class="home-section__subtitle">{{ $h['curriculum_subtitle'] ?? ($h['curriculum_intro'] ?? '') }}</p>
            </header>

            @if(!empty($pillars))
                <div class="ace-feature-grid">
                    @foreach($pillars as $i => $pillar)
                        <article class="ace-feature-card">
                            <div class="ace-feature-card__cap" aria-hidden="true"></div>
                            <div class="ace-feature-card__icon" aria-hidden="true">
                                @if($i === 0)
                                    <svg viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="14" stroke="currentColor" stroke-width="2.5"/><circle cx="24" cy="24" r="7" stroke="currentColor" stroke-width="2.5"/><circle cx="24" cy="24" r="2.5" fill="currentColor"/></svg>
                                @elseif($i === 1)
                                    <svg viewBox="0 0 48 48" fill="none"><path d="M24 10v28M24 10c-6 0-12 2-12 6v22c0-4 6-6 12-6M24 10c6 0 12 2 12 6v22c0-4-6-6-12-6" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/><path d="M24 18v4" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                                @else
                                    <svg viewBox="0 0 48 48" fill="none"><path d="M24 8a10 10 0 00-6 18c.8 1.2 1.2 2.4 1.2 3.6V32h9.6v-2.4c0-1.2.4-2.4 1.2-3.6A10 10 0 0024 8z" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/><path d="M20 36h8M21 40h6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                                @endif
                            </div>
                            <div class="ace-feature-card__body">
                                @if(!empty($pillar['title']))
                                    <h3>{{ $pillar['title'] }}</h3>
                                @endif
                                @if(!empty($pillar['description']))
                                    <p>{{ $pillar['description'] }}</p>
                                @endif
                                <a href="{{ route('departments.index') }}" class="ace-feature-card__link" wire:navigate>
                                    {{ $h['curriculum_link_text'] ?? 'Learn more' }} →
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Programs --}}
    @if($departments->isNotEmpty())
        <section class="home-section home-programs" id="programs" aria-labelledby="home-programs-title">
            <div class="content home-section__inner">
                <div class="home-programs__layout">
                    <div class="home-programs__copy">
                        <p class="section-heading">{{ $h['programs_label'] ?? 'Programs' }}</p>
                        <h2 id="home-programs-title" class="home-programs__title">{{ $h['programs_title'] ?? 'Nursery & Primary Programs' }}</h2>
                        <p class="home-programs__text">{{ $h['programs_subtitle'] ?? ($h['curriculum_intro'] ?? '') }}</p>
                        <a href="{{ route('departments.index') }}" class="btn-secondary" wire:navigate>
                            {{ $h['programs_link_text'] ?? 'View all programs' }}
                        </a>
                    </div>
                    <div class="home-programs__cards">
                        @foreach($departments->take(2) as $department)
                            <a href="{{ route('departments.show', ['department' => $department->slug ?: $department->id]) }}" class="level-card" wire:navigate>
                                <div class="level-card__media">
                                    @if($department->cover_image)
                                        <img src="{{ asset($department->cover_image) }}" alt="{{ $department->name }}" loading="lazy">
                                    @else
                                        <div class="level-card__placeholder"></div>
                                    @endif
                                </div>
                                <span class="level-card__label">
                                    {{ $department->name }}
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M9 18l6-6-6-6"/></svg>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Core values — full-bleed parallax --}}
    @php
        $valuesBg = $settings->cta_background_image_path
            ?? $settings->home_background_image_path
            ?? ($sliders->first()->image_path ?? null);
    @endphp
    <section class="values-parallax" id="core-values" aria-labelledby="core-values-title">
        <div class="values-parallax__bg {{ $valuesBg ? '' : 'values-parallax__bg--fallback' }}"
             @if($valuesBg) style="background-image: url('{{ asset($valuesBg) }}');" @endif
             aria-hidden="true"></div>
        <div class="values-parallax__overlay" aria-hidden="true"></div>
        <div class="values-parallax__content content home-section__inner">
            <header class="home-section__head home-section__head--light">
                <h2 id="core-values-title" class="home-section__title">{{ $h['why_choose_title'] ?? 'Our Core Values' }}</h2>
                @if(!empty(optional($settings)->about_values_subheading) && optional($settings)->about_values_subheading !== ($h['why_choose_title'] ?? 'Our Core Values'))
                    <p class="home-section__subtitle">{{ $settings->about_values_subheading }}</p>
                @endif
            </header>

            @if(!empty($whyChooseCards))
                <div class="values-parallax__grid">
                    @foreach($whyChooseCards as $i => $card)
                        @php $iconTone = $i % 4; @endphp
                        <article class="values-parallax__item">
                            <div class="values-parallax__icon values-parallax__icon--{{ $iconTone }}" aria-hidden="true">
                                @if($iconTone === 0)
                                    <svg viewBox="0 0 48 48" fill="none"><circle cx="24" cy="18" r="8" stroke="currentColor" stroke-width="2.5"/><path d="M10 40c2.5-8 9-12 14-12s11.5 4 14 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/><path d="M30 14l4-6M18 14l-4-6M24 8V2" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                                @elseif($iconTone === 1)
                                    <svg viewBox="0 0 48 48" fill="none"><rect x="10" y="8" width="28" height="32" rx="3" stroke="currentColor" stroke-width="2.5"/><path d="M18 18h12M18 24h12M18 30h8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/><circle cx="34" cy="34" r="8" fill="transparent" stroke="currentColor" stroke-width="2.5"/><path d="M31 34l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                @elseif($iconTone === 2)
                                    <svg viewBox="0 0 48 48" fill="none"><path d="M24 6l14 8v12c0 10-6 16-14 20-8-4-14-10-14-20V14l14-8z" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/><path d="M18 24l4 4 8-8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                @else
                                    <svg viewBox="0 0 48 48" fill="none"><path d="M16 38V18l8-6 8 6v20" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/><path d="M16 22h16M20 28h8M22 34h4" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/><circle cx="24" cy="12" r="3" fill="currentColor"/></svg>
                                @endif
                            </div>
                            @if(!empty($card['name']))
                                <h3 class="values-parallax__item-title">{{ $card['name'] }}</h3>
                            @endif
                            @if(!empty($card['description']))
                                <p class="values-parallax__item-desc">{{ strip_tags($card['description']) }}</p>
                            @endif
                        </article>
                    @endforeach
                </div>
            @else
                <p class="values-parallax__empty">{{ $h['why_choose_empty'] ?? '' }}</p>
            @endif

            <div class="values-parallax__cta">
                <a href="{{ url('/about#core-values') }}" class="btn-primary">
                    {{ $h['overview_link_text'] ?? 'More About Our School' }}
                </a>
            </div>
        </div>
    </section>

    {{-- Explore our school --}}
    <section class="home-section home-explore" id="explore" aria-labelledby="home-explore-title">
        <div class="content home-section__inner">
            <header class="home-section__head">
                <p class="section-heading">{{ $h['explore_label'] ?? 'Discover more' }}</p>
                <h2 id="home-explore-title" class="home-section__title">{{ $h['explore_title'] ?? 'Explore Our School' }}</h2>
                @if(!empty($h['explore_subtitle']))
                    <p class="home-section__subtitle">{{ $h['explore_subtitle'] }}</p>
                @endif
            </header>

            <div class="home-explore__grid">
                @foreach($exploreCards as $i => $card)
                    @php
                        $key = $card['key'] ?? ('card-'.$i);
                        $img = $exploreImages[$key] ?? null;
                        $url = $heroPrimaryUrl($card['url'] ?? '/');
                    @endphp
                    <a href="{{ $url }}" class="explore-card" wire:navigate>
                        <div class="explore-card__media">
                            @if($img)
                                <img src="{{ asset($img) }}" alt="{{ $card['title'] ?? 'Explore' }}" loading="lazy">
                            @else
                                <div class="explore-card__placeholder explore-card__placeholder--{{ $i % 3 }}"></div>
                            @endif
                            <span class="explore-card__icon" aria-hidden="true">
                                @if(($card['key'] ?? '') === 'facilities' || $i === 1)
                                    <svg viewBox="0 0 48 48" fill="none"><path d="M8 40V20l16-10 16 10v20" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/><path d="M18 40V28h12v12" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/><path d="M20 18h8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                                @elseif(($card['key'] ?? '') === 'activities' || $i === 2)
                                    <svg viewBox="0 0 48 48" fill="none"><path d="M24 8a10 10 0 00-6 18c.8 1.2 1.2 2.4 1.2 3.6V32h9.6v-2.4c0-1.2.4-2.4 1.2-3.6A10 10 0 0024 8z" stroke="currentColor" stroke-width="2.5"/><path d="M20 36h8M21 40h6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                                @else
                                    <svg viewBox="0 0 48 48" fill="none"><path d="M12 34V18l12-8 12 8v16" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/><path d="M20 34v-8h8v8M18 22h12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                @endif
                            </span>
                        </div>
                        <div class="explore-card__body">
                            @if(!empty($card['title']))
                                <h3>{{ $card['title'] }}</h3>
                            @endif
                            @if(!empty($card['description']))
                                <p>{{ $card['description'] }}</p>
                            @endif
                            <span class="explore-card__link">{{ $h['explore_link_text'] ?? 'Learn more' }} →</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Gallery / Life at school --}}
    @php
        $g = $siteContent['gallery'] ?? [];
        $galleryLink = ($settings->gallery_external_url ?? null)
            ? $settings->gallery_external_url
            : route('gallery.index');
        $galleryLinkExternal = (bool) ($settings->gallery_external_url ?? null);
    @endphp
    <section class="home-section home-gallery" id="gallery" aria-labelledby="home-gallery-title">
        <div class="content home-section__inner">
            <header class="home-section__head">
                <p class="section-heading">{{ $h['news_label'] ?? ($g['section_label'] ?? 'Gallery') }}</p>
                <h2 id="home-gallery-title" class="home-section__title">{{ $h['news_title'] ?? ($g['section_title'] ?? 'Life at our school') }}</h2>
                @if(!empty($g['section_subtitle']))
                    <p class="home-section__subtitle">{{ $g['section_subtitle'] }}</p>
                @endif
                @if($galleryImages->isNotEmpty())
                    @if($galleryLinkExternal)
                        <a href="{{ $galleryLink }}" class="btn-outline home-section__cta" target="_blank" rel="noopener noreferrer">
                            {{ $h['news_link_text'] ?? 'View full gallery' }}
                        </a>
                    @else
                        <a href="{{ $galleryLink }}" class="btn-outline home-section__cta" wire:navigate>
                            {{ $h['news_link_text'] ?? 'View full gallery' }}
                        </a>
                    @endif
                @endif
            </header>

            @if($galleryImages->isNotEmpty())
                <div class="home-gallery__wrap"
                     x-data="{
                         lightboxOpen: false,
                         lightboxIndex: 0,
                         images: @json($galleryLightboxImages),
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
