<div>
    <x-page-locator title="School Activities" :header="$header" />
    <div class="content">
        <div class="standard-page">
            <div class="standard-page__intro">
                <p class="standard-page__lead">We offer a variety of activities—sports, clubs, arts, and community events—to enrich student life and develop talents beyond the classroom.</p>
            </div>
            <div class="standard-page__body">
                <p>Content for this page can be managed from the admin <strong>Settings → Page headers</strong>. You can also link to the <a href="{{ route('gallery.index') }}" wire:navigate>Gallery</a> for photos of recent activities.</p>
            </div>
        </div>
    </div>
    <style>
    .standard-page { margin: 40px 0 60px; max-width: 800px; margin-left: auto; margin-right: auto; }
    .standard-page__intro { margin-bottom: 28px; }
    .standard-page__lead { font-size: 1.1rem; color: #444; line-height: 1.7; }
    .standard-page__body { font-size: 1rem; color: #555; line-height: 1.7; }
    .standard-page__body a { color: var(--primary); text-decoration: none; }
    .standard-page__body a:hover { text-decoration: underline; }
    </style>
</div>
