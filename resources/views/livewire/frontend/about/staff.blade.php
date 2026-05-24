<div>
    <x-page-locator title="Our staff" :header="$header" />
    @php $a = $siteContent['about'] ?? []; @endphp

    <div class="content page-wrap about-page">
        <x-about-section-header
            :label="$a['staff_label'] ?? 'Our team'"
            :title="$a['staff_title'] ?? 'Our staff'"
            :subtitle="$a['staff_subtitle'] ?? ''"
        />

        @if($staff->isNotEmpty())
            <div class="team-container team-container--about {{ $staff->count() <= 2 ? 'team-container--centered' : '' }}">
                @foreach($staff as $member)
                    <a href="{{ route('leadership.show', ['member' => $member->id, 'slug' => \Illuminate\Support\Str::slug($member->full_name)]) }}" class="team-container-item" wire:navigate>
                        <div class="img">
                            @if($member->profile_image)
                                <img src="{{ asset($member->profile_image) }}" alt="{{ $member->full_name }}" loading="lazy">
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
        @else
            <p class="page-lead page-lead--center">{{ $a['staff_empty'] ?? 'Staff profiles will appear here once added in Admin → Staff.' }}</p>
        @endif
    </div>
</div>
