@props(['partners', 'heading' => 'Our Partners', 'variant' => 'footer'])

@if($partners->isNotEmpty())
    <section class="partners-panel partners-panel--{{ $variant }}" aria-label="{{ $heading }}">
        <h3 class="partners-panel__heading partners-panel__heading--footer">{{ $heading }}</h3>
        <div class="partners-panel__list">
            @foreach($partners as $partner)
                @if($partner->website_url)
                    <a href="{{ $partner->website_url }}"
                       class="partners-panel__item"
                       target="_blank"
                       rel="noopener noreferrer"
                       title="{{ $partner->name }}">
                        @if($partner->logo_path)
                            <img src="{{ asset($partner->logo_path) }}" alt="{{ $partner->name }}" loading="lazy">
                        @else
                            <span class="partners-panel__fallback">{{ $partner->name }}</span>
                        @endif
                    </a>
                @else
                    <div class="partners-panel__item partners-panel__item--static" title="{{ $partner->name }}">
                        @if($partner->logo_path)
                            <img src="{{ asset($partner->logo_path) }}" alt="{{ $partner->name }}" loading="lazy">
                        @else
                            <span class="partners-panel__fallback">{{ $partner->name }}</span>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endif
