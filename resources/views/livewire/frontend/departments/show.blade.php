<div>
    @if($department->cover_image)
        <div class="dept-cover-outer">
            <div class="dept-cover">
                <img src="{{ asset($department->cover_image) }}" alt="{{ $department->name }}" class="dept-cover__img">
            </div>
        </div>
    @endif
<div class="content">
    <div class="department-single">
        <div class="dept-header">
            <h1 class="dept-title">{{ $department->name }}</h1>
            @if($department->description)
                <div class="dept-description">{!! $department->description !!}</div>
            @endif
        </div>

        @if(!empty($gallery))
            <section class="gallery-section">
                <h2 class="section-heading">Gallery</h2>
                <div class="gallery-grid">
                    @foreach($gallery as $path)
                        <a href="{{ asset($path) }}" target="_blank" rel="noopener" class="gallery-item">
                            <img src="{{ asset($path) }}" alt="">
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>
<style>
.department-single { padding: 30px 0; }
.dept-cover-outer {
    width: 100vw;
    max-width: 100vw;
    position: relative;
    left: 50%;
    margin-left: -50vw;
    height: 100vh;
    min-height: 100vh;
    overflow: hidden;
    margin-bottom: 0;
}
.dept-cover {
    width: 100%;
    height: 100%;
    position: relative;
    overflow: hidden;
}
.dept-cover__img,
.dept-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    animation: dept-zoom-in 5s ease-out forwards;
}
@keyframes dept-zoom-in {
    from { transform: scale(1); }
    to { transform: scale(1.08); }
}
.dept-title { font-size: 1.8rem; font-weight: 600; margin-bottom: 16px; }
.dept-description { font-size: 0.95rem; line-height: 1.6; color: #555; margin-bottom: 40px; }
.gallery-section { margin: 40px 0; }
.gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
.gallery-item { display: block; border-radius: 8px; overflow: hidden; }
.gallery-item img { width: 100%; aspect-ratio: 1; object-fit: cover; }
</style>
</div>
