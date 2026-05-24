<div>
<x-page-locator title="Leadership Team" :header="$header" />
<div class="content page-wrap">
    <div class="leadership-list">
        @php $l = $siteContent['leadership'] ?? []; @endphp
        <div class="section-header">
            <p class="section-heading">{{ $l['section_label'] ?? 'Our team' }}</p>
            <h2 class="section-title">{{ $l['section_title'] ?? 'Educators & Leaders' }}</h2>
            <p class="section-sub section-sub--center">{{ $l['section_subtitle'] ?? '' }}</p>
        </div>
        <div class="team-container">
            @foreach($members as $member)
                <a href="{{ route('leadership.show', ['member' => $member->id, 'slug' => \Illuminate\Support\Str::slug($member->full_name)]) }}" class="team-container-item" wire:navigate>
                    <div class="img">
                        @if($member->profile_image)
                            <img src="{{ asset($member->profile_image) }}" alt="{{ $member->full_name }}">
                        @else
                            <div class="img-placeholder"></div>
                        @endif
                    </div>
                    <div class="team-container-item-content">
                        <h4 class="name">{{ $member->full_name }}</h4>
                        @if($member->position)
                            <label class="title">{{ $member->position }}</label>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
</div>
