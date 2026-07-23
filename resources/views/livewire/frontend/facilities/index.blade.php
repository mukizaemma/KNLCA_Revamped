<div>
    <x-page-locator title="Facilities" :header="$header" />
    @php $f = $siteContent['facilities'] ?? []; @endphp
    <div class="content page-wrap">
        <div class="facilities-page">
            <div class="section-header">
                <p class="section-heading">{{ $f['section_label'] ?? 'Our campus' }}</p>
                <h2 class="section-title">{{ $f['section_title'] ?? 'Spaces for learning & play' }}</h2>
                <p class="page-lead page-lead--center">{{ $f['section_intro'] ?? '' }}</p>
            </div>
            <div class="facilities-grid">
                @forelse($facilities ?? [] as $facility)
                    <a href="{{ route('facilities.show', ['facility' => $facility->slug ?: $facility->id]) }}" class="facility-card" wire:navigate>
                        <div class="facility-card__img-wrap">
                            @if($facility->image_path)
                                <img src="{{ asset($facility->image_path) }}" alt="{{ $facility->name }}" class="facility-card__img facility-card__img--zoom">
                            @else
                                <div class="facility-card__placeholder"></div>
                            @endif
                        </div>
                        <h3 class="facility-card__title">{{ $facility->name }}</h3>
                        @if($facility->shortDescription())
                            <p class="facility-card__desc">{{ $facility->shortDescription(150) }}</p>
                        @endif
                        <span class="facility-card__link">Read more</span>
                    </a>
                @empty
                    <p class="lead text-muted">{{ $f['empty'] ?? 'Facilities will be listed here.' }}</p>
                @endforelse
            </div>
            <div class="page-cta">
                <h3 class="page-cta__title">{{ $f['cta_title'] ?? 'See our campus in person' }}</h3>
                <p class="page-cta__text">{{ $f['cta_text'] ?? '' }}</p>
                <div class="page-cta__actions">
                    <a href="{{ url('/about#inquire') }}" class="btn-primary">{{ $f['cta_btn'] ?? 'Schedule a visit' }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
