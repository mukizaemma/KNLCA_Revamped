<div>
<x-page-locator title="Academics" :header="$header" />
<div class="content page-wrap">
    <div class="programs-list">
        @php $d = $siteContent['departments'] ?? []; @endphp
        <div class="section-header">
            <p class="section-heading">{{ $d['section_label'] ?? 'ACE curriculum' }}</p>
            <h2 class="section-title">{{ $d['section_title'] ?? 'Nursery & Primary Programs' }}</h2>
            <p class="section-sub section-sub--center">{{ $d['section_subtitle'] ?? '' }}</p>
        </div>
        <div class="programs-grid programs-grid--page programs-grid--two">
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
                    <p class="program-card__desc">{{ \Illuminate\Support\Str::limit(strip_tags($department->description ?? ''), 100) ?: ($d['card_fallback'] ?? '') }}</p>
                    <span class="program-card__btn">Learn more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
                    <span class="program-card__line"></span>
                </a>
            @endforeach
        </div>
    </div>
</div>
</div>
