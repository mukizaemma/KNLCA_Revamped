<div>
    <x-page-locator title="Our schools" :header="$header" />
    @php $a = $siteContent['about'] ?? []; @endphp

    <div class="content page-wrap about-page">
        <x-about-section-header
            :label="$a['affiliate_label'] ?? 'New Life family'"
            :title="$a['affiliate_title'] ?? 'Our schools'"
            :subtitle="$a['affiliate_subtitle'] ?? ''"
        />

        @if(!empty($affiliateSchools))
            <div class="affiliate-schools-grid">
                @foreach($affiliateSchools as $school)
                    <article class="affiliate-school-card">
                        <h3>{{ $school['name'] }}</h3>
                        @if(!empty($school['location']))
                            <p class="affiliate-school-card__meta">{{ $school['location'] }}</p>
                        @endif
                        @if(!empty($school['description']))
                            <p>{{ $school['description'] }}</p>
                        @endif
                        @if(!empty($school['url']))
                            <a href="{{ $school['url'] }}" class="btn-outline" target="_blank" rel="noopener noreferrer">Visit website</a>
                        @endif
                    </article>
                @endforeach
            </div>
        @else
            <p class="page-lead page-lead--center">{{ $a['affiliate_empty'] ?? 'Add affiliate schools in Admin → School Info when you are ready.' }}</p>
        @endif
    </div>
</div>
