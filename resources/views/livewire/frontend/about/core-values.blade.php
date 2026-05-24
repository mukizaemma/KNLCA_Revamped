<div>
    <x-page-locator title="Core values" :header="$header" />
    @php $a = $siteContent['about'] ?? []; @endphp

    <div class="content page-wrap about-page">
        <x-about-section-header :title="$a['core_values_title'] ?? 'Our core values'" />

        @php
            $cv = is_string(optional($settings)->core_values ?? '') ? ($settings->core_values ?? '') : '';
            $hasHtml = strip_tags($cv) !== $cv;
            $items = [];
            if (!$hasHtml && !empty(trim($cv))) {
                $items = preg_split('/[\n\r,;]+/', $cv, -1, PREG_SPLIT_NO_EMPTY);
                $items = array_map('trim', array_filter($items));
            }
        @endphp

        @if(!empty($valueCards))
            <div class="values-grid values-grid--about">
                @foreach($valueCards as $card)
                    <div class="value-card">
                        <div class="value-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" class="value-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        @if(!empty($card['name']))
                            <h3 class="value-title">{{ $card['name'] }}</h3>
                        @endif
                        @if(!empty($card['description']))
                            <p class="value-desc">{{ $card['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @elseif(!$hasHtml && !empty($items))
            <div class="about-core-values-box">
                <ul class="values-list values-list--centered">
                    @foreach($items as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif(!empty(trim(strip_tags($cv))))
            <div class="about-core-values-box about-rich-text">{!! $cv !!}</div>
        @else
            <p class="page-lead page-lead--center">Add core values in Admin → School Info, or value cards under About settings.</p>
        @endif
    </div>
</div>
