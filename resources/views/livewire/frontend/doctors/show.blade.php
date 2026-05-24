<div>
<div class="content">
    <div class="doctor-single">
        <div class="doctor-header">
            <div class="doctor-photo">
                @if($doctor->profile_image)
                    <img src="{{ asset($doctor->profile_image) }}" alt="{{ $doctor->full_name }}">
                @else
                    <div class="img-placeholder"></div>
                @endif
            </div>
            <div class="doctor-info">
                <h1 class="doctor-name">{{ $doctor->full_name }}</h1>
                @if($doctor->department)
                    <p class="doctor-dept">{{ $doctor->department->name }}</p>
                @endif
                @if($doctor->position)
                    <p class="doctor-position">{{ $doctor->position }}</p>
                @endif
                @if($doctor->phone)
                    <p><a href="tel:{{ $doctor->phone }}">{{ $doctor->phone }}</a></p>
                @endif
                @if($doctor->email)
                    <p><a href="mailto:{{ $doctor->email }}">{{ $doctor->email }}</a></p>
                @endif
            </div>
        </div>
        @if($doctor->biography)
            <div class="doctor-bio">
                <h2 class="section-heading">Biography</h2>
                <div class="bio-content">{!! $doctor->biography !!}</div>
            </div>
        @endif
    </div>
</div>
<style>
.doctor-single { padding: 30px 0; }
.doctor-header { display: grid; grid-template-columns: 280px 1fr; gap: 40px; align-items: start; margin-bottom: 40px; }
@media (max-width: 768px) { .doctor-header { grid-template-columns: 1fr; } }
.doctor-photo { width: 100%; aspect-ratio: 1; border-radius: 12px; overflow: hidden; }
.doctor-photo img { width: 100%; height: 100%; object-fit: cover; }
.img-placeholder { width: 100%; height: 100%; background: linear-gradient(135deg, #f5f5f5, #e0e0e0); }
.doctor-name { font-size: 1.8rem; font-weight: 600; margin-bottom: 8px; }
.doctor-dept { font-size: 1rem; color: var(--primary); margin-bottom: 4px; }
.doctor-position { font-size: 0.9rem; color: #666; margin-bottom: 16px; }
.doctor-info a { color: var(--primary); text-decoration: none; }
.doctor-info a:hover { text-decoration: underline; }
.doctor-bio { padding-top: 24px; border-top: 1px solid #eee; }
.bio-content { font-size: 0.95rem; line-height: 1.7; color: #555; }
</style>
</div>
