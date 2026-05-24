@props(['title' => 'Page', 'header' => null])
@php
    use App\Support\SiteContent;

    $displayTitle = trim(strip_tags($header && $header->title ? $header->title : $title));
    $rawCaption = $header && $header->caption ? $header->caption : null;
    $hasCaption = SiteContent::hasRichTextContent($rawCaption);
@endphp
<div class="locator-outer">
    <div class="locator">
        @if($header && $header->image_path)
            <img src="{{ asset($header->image_path) }}" alt="{{ $displayTitle }}" class="locator-img">
        @else
            <div class="locator-placeholder"></div>
        @endif
        <div class="locator-overlay"></div>
        <div class="locator-text {{ $hasCaption ? 'locator-text--with-caption' : '' }}">
            <div class="locator-left">
                <h1 class="locator-title">{{ $displayTitle }}</h1>
                <span class="locator-accent" aria-hidden="true"></span>
            </div>
            @if($hasCaption)
                <div class="locator-right">
                    <div class="locator-caption">{!! $rawCaption !!}</div>
                </div>
            @endif
        </div>
        <div class="locator-wave" aria-hidden="true">
            <svg viewBox="0 0 1440 48" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="#ffffff" d="M0,32 C240,48 480,0 720,24 C960,48 1200,8 1440,28 L1440,48 L0,48 Z"/>
            </svg>
        </div>
    </div>
</div>
