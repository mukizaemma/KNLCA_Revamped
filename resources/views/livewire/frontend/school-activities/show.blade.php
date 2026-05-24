<div>
    @if($activity->image_path)
        <div class="activity-hero-outer">
            <div class="activity-hero">
                <img src="{{ asset($activity->image_path) }}" alt="{{ $activity->title }}" class="activity-hero__img">
            </div>
        </div>
    @endif
    <div class="content">
        <article class="activity-single">
            <a href="{{ route('school-activities') }}" class="activity-single__back" wire:navigate>&larr; Back to School Activities</a>
            <header class="activity-single__header">
                <h1 class="activity-single__title">{{ $activity->title }}</h1>
                @if($activity->published_at)
                    <p class="activity-single__date">{{ $activity->published_at->format('F j, Y') }}</p>
                @endif
            </header>
            @if($activity->content)
                <div class="activity-single__content">{!! $activity->content !!}</div>
            @endif
            @if($activity->galleryImages->isNotEmpty())
                <section class="activity-gallery mt-5">
                    <h2 class="activity-gallery__title">Event gallery</h2>
                    <div class="activity-gallery__grid">
                        @foreach($activity->galleryImages as $img)
                            <div class="activity-gallery__item">
                                <img src="{{ asset($img->image_path) }}" alt="{{ $img->caption ?? $activity->title }}" loading="lazy">
                                @if($img->caption)
                                    <p class="activity-gallery__caption">{{ $img->caption }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </article>
    </div>
    <style>
    .activity-hero-outer {
        width: 100vw; max-width: 100vw;
        position: relative; left: 50%; margin-left: -50vw;
        height: 100vh; min-height: 100vh;
        overflow: hidden; margin-bottom: 0;
    }
    .activity-hero { width: 100%; height: 100%; position: relative; overflow: hidden; }
    .activity-hero__img {
        width: 100%; height: 100%;
        object-fit: cover; object-position: center;
        animation: locator-zoom-in 5s ease-out forwards;
    }
    .activity-single { padding: 40px 0 60px; max-width: 800px; margin: 0 auto; }
    .activity-single__back { display: inline-block; margin-bottom: 24px; color: var(--primary); text-decoration: none; font-weight: 500; }
    .activity-single__back:hover { text-decoration: underline; }
    .activity-single__title { font-size: 1.75rem; font-weight: 700; margin-bottom: 8px; color: var(--navy); }
    .activity-single__date { font-size: 0.95rem; color: #888; margin-bottom: 24px; }
    .activity-single__content { font-size: 1rem; line-height: 1.7; color: #444; }
    .activity-single__content p { margin-bottom: 1em; }
    .activity-single__content img { max-width: 100%; height: auto; border-radius: 4px; }
    .activity-gallery__title { font-size: 1.25rem; font-weight: 600; color: var(--navy); margin-bottom: 16px; }
    .activity-gallery__grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
    .activity-gallery__item { border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .activity-gallery__item img { width: 100%; height: 200px; object-fit: cover; display: block; }
    .activity-gallery__caption { font-size: 0.85rem; color: #666; padding: 8px 12px; margin: 0; }
    </style>
</div>
