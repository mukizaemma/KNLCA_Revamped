<div>
    <x-page-locator title="School Activities" :header="$header" />
    <div class="content page-wrap">
        <div class="activities-page">
            @php $act = $siteContent['activities'] ?? []; @endphp
            <div class="section-header">
                <p class="section-heading">{{ $act['section_label'] ?? 'School life' }}</p>
                <h2 class="section-title">{{ $act['section_title'] ?? 'News, events & activities' }}</h2>
                <p class="page-lead page-lead--center">{{ $act['section_intro'] ?? '' }}</p>
            </div>
            <div class="activities-grid">
                @forelse($activities as $activity)
                    <a href="{{ route('school-activities.show', ['activity' => $activity->slug ?: $activity->id]) }}" class="activity-card" wire:navigate>
                        <div class="activity-card__img-wrap">
                            @if($activity->image_path)
                                <img src="{{ asset($activity->image_path) }}" alt="{{ $activity->title }}" class="activity-card__img">
                            @else
                                <div class="activity-card__placeholder"></div>
                            @endif
                        </div>
                        <div class="activity-card__body">
                            <h3 class="activity-card__title">{{ $activity->title }}</h3>
                            <p class="activity-card__meta">{{ $activity->published_at?->format('F j, Y') }}</p>
                            @if($activity->excerpt)
                                <p class="activity-card__excerpt">{{ \Illuminate\Support\Str::limit($activity->excerpt, 120) }}</p>
                            @endif
                            <span class="activity-card__link">Read more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
                        </div>
                    </a>
                @empty
                    <p class="lead text-muted">{{ $act['empty'] ?? 'No activities yet.' }}</p>
                @endforelse
            </div>
            @if($activities->hasPages())
                <div class="activities-pagination mt-4">{{ $activities->links() }}</div>
            @endif
        </div>
    </div>
</div>
