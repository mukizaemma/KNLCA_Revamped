<div>
    <x-page-locator title="Our history" :header="$header" />
    @php $a = $siteContent['about'] ?? []; @endphp

    <div class="content page-wrap about-page">
        <x-about-section-header
            :title="$a['history_title'] ?? 'Our history'"
            :subtitle="$a['history_intro'] ?? ''"
        />

        @if(!empty($a['history_body']))
            <div class="about-history about-rich-text">{!! $a['history_body'] !!}</div>
        @else
            <p class="page-lead page-lead--center">School history can be edited in Admin → Page Content → About.</p>
        @endif
    </div>
</div>
