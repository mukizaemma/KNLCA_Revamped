<div>
    <x-page-locator title="Mission &amp; vision" :header="$header" />
    @php $a = $siteContent['about'] ?? []; @endphp

    <div class="content page-wrap about-page">
        <x-about-section-header :title="$a['mission_vision_title'] ?? 'Our mission & vision'" />

        @if($settings && ($settings->mission || $settings->vision))
            <div class="about-mv-grid">
                @if($settings->mission)
                    <article class="about-mv-card">
                        <div class="about-mv-card__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        </div>
                        <h3>Our mission</h3>
                        <div class="about-mv-body">{!! $settings->mission !!}</div>
                    </article>
                @endif
                @if($settings->vision)
                    <article class="about-mv-card">
                        <div class="about-mv-card__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <h3>Our vision</h3>
                        <div class="about-mv-body">{!! $settings->vision !!}</div>
                    </article>
                @endif
            </div>
        @else
            <p class="page-lead page-lead--center">Mission and vision statements can be added in Admin → School Info.</p>
        @endif
    </div>
</div>
