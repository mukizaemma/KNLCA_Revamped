<div>
    @if($facility->image_path)
        <div class="facility-hero-outer">
            <div class="facility-hero">
                <img src="{{ asset($facility->image_path) }}" alt="{{ $facility->name }}" class="facility-hero__img">
            </div>
        </div>
    @endif
    <div class="content">
        <article class="facility-single">
            <a href="{{ route('facilities') }}" class="facility-single__back" wire:navigate>&larr; Back to Facilities</a>
            <header class="facility-single__header">
                <h1 class="facility-single__title">{{ $facility->name }}</h1>
            </header>
            @if($facility->description)
                <div class="facility-single__content">{!! $facility->description !!}</div>
            @endif
        </article>
    </div>
    <style>
    .facility-hero-outer {
        width: 100vw; max-width: 100vw;
        position: relative; left: 50%; margin-left: -50vw;
        height: min(70vh, 560px); min-height: 280px;
        overflow: hidden; margin-bottom: 0;
    }
    .facility-hero { width: 100%; height: 100%; position: relative; overflow: hidden; }
    .facility-hero__img {
        width: 100%; height: 100%;
        object-fit: cover; object-position: center;
    }
    .facility-single { padding: 40px 0 60px; max-width: 800px; margin: 0 auto; }
    .facility-single__back { display: inline-block; margin-bottom: 24px; color: var(--primary); text-decoration: none; font-weight: 500; }
    .facility-single__back:hover { text-decoration: underline; }
    .facility-single__title { font-size: 1.75rem; font-weight: 700; margin-bottom: 20px; color: var(--navy); }
    .facility-single__content { font-size: 1rem; line-height: 1.7; color: #444; }
    .facility-single__content p { margin-bottom: 1em; }
    .facility-single__content img { max-width: 100%; height: auto; border-radius: 4px; }
    </style>
</div>
