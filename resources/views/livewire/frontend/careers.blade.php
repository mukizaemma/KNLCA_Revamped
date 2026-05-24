<div>
    <x-page-locator title="Careers" :header="$header" />
    @php $c = $siteContent['careers'] ?? []; @endphp
    <div class="content page-wrap">
        <div class="standard-page">
            <div class="section-header">
                <p class="section-heading">{{ $c['section_label'] ?? 'Join our team' }}</p>
                <h2 class="section-title">{{ $c['section_title'] ?? 'Careers at our ACE school' }}</h2>
                <p class="standard-page__lead page-lead page-lead--center">{{ $c['section_intro'] ?? '' }}</p>
            </div>
            <div class="standard-page__body">
                {!! $c['body'] ?? '' !!}
                <div class="page-cta" style="margin-top:32px;">
                    <p class="page-cta__text">{{ $c['cta_title'] ?? 'Interested in joining our team?' }}</p>
                    <div class="page-cta__actions">
                        <a href="{{ route('about') }}#inquire" class="btn-primary" wire:navigate>{{ $c['cta_btn'] ?? 'Contact us' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
