<div>
    <x-page-locator title="About us" :header="$header" />
    @php $a = $siteContent['about'] ?? []; @endphp

    <div class="content page-wrap about-page">
        <section class="about-section about-section--intro">
            <x-about-section-header
                :label="$a['overview_label'] ?? 'School overview'"
                :title="optional($settings)->about_heading ?? 'Nurturing young minds through ACE excellence'"
            />
            @if($settings?->about_description)
                <div class="about-description about-description--block">{!! $settings->about_description !!}</div>
            @else
                <p class="page-lead page-lead--center">{{ $a['overview_fallback'] ?? '' }}</p>
            @endif
        </section>

        <section class="about-hub" aria-label="Explore more about our school">
            <div class="about-hub__grid">
                <a href="{{ route('about.mission-vision') }}" class="about-hub__card" wire:navigate>
                    <span class="about-hub__icon" aria-hidden="true">◎</span>
                    <h3>Mission &amp; vision</h3>
                    <p>What drives us and where we are headed.</p>
                </a>
                <a href="{{ route('about.core-values') }}" class="about-hub__card" wire:navigate>
                    <span class="about-hub__icon" aria-hidden="true">◆</span>
                    <h3>Core values</h3>
                    <p>The principles that shape our school culture.</p>
                </a>
                <a href="{{ route('about.staff') }}" class="about-hub__card" wire:navigate>
                    <span class="about-hub__icon" aria-hidden="true">☺</span>
                    <h3>Our staff</h3>
                    <p>Meet the educators and leaders on our team.</p>
                </a>
                <a href="{{ route('about.history') }}" class="about-hub__card" wire:navigate>
                    <span class="about-hub__icon" aria-hidden="true">⏳</span>
                    <h3>Our history</h3>
                    <p>The story of our school community.</p>
                </a>
                <a href="{{ route('about.our-schools') }}" class="about-hub__card" wire:navigate>
                    <span class="about-hub__icon" aria-hidden="true">🏫</span>
                    <h3>Our schools</h3>
                    <p>Campuses in the New Life family.</p>
                </a>
                <a href="{{ route('about.inquire') }}" class="about-hub__card about-hub__card--accent" wire:navigate>
                    <span class="about-hub__icon" aria-hidden="true">✉</span>
                    <h3>Get in touch</h3>
                    <p>Questions, visits, or admissions—we are here to help.</p>
                </a>
            </div>
        </section>
    </div>
</div>
