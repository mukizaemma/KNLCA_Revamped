<div>
<div class="content">
    <div class="member-single">
        <div class="member-header">
            <div class="member-photo">
                @if($member->profile_image)
                    <img src="{{ asset($member->profile_image) }}" alt="{{ $member->full_name }}">
                @else
                    <div class="img-placeholder"></div>
                @endif
            </div>
            <div class="member-info">
                <h1 class="member-name">{{ $member->full_name }}</h1>
                @if($member->position)
                    <p class="member-position">{{ $member->position }}</p>
                @endif
                @if($member->phone)
                    <p><a href="tel:{{ $member->phone }}">{{ $member->phone }}</a></p>
                @endif
                @if($member->email)
                    <p><a href="mailto:{{ $member->email }}">{{ $member->email }}</a></p>
                @endif
            </div>
        </div>
        @if($member->biography)
            <div class="member-bio">
                <h2 class="section-heading">Biography</h2>
                <div class="bio-content">{!! $member->biography !!}</div>
            </div>
        @endif
    </div>
</div>
<style>
.member-single { padding: 30px 0; }
.member-header { display: grid; grid-template-columns: 280px 1fr; gap: 40px; align-items: start; margin-bottom: 40px; }
@media (max-width: 768px) { .member-header { grid-template-columns: 1fr; } }
.member-photo { width: 100%; aspect-ratio: 1; border-radius: 12px; overflow: hidden; }
.member-photo img { width: 100%; height: 100%; object-fit: cover; }
.img-placeholder { width: 100%; height: 100%; background: linear-gradient(135deg, #f5f5f5, #e0e0e0); }
.member-name { font-size: 1.8rem; font-weight: 600; margin-bottom: 8px; }
.member-position { font-size: 1rem; color: var(--primary); margin-bottom: 16px; }
.member-info a { color: var(--primary); text-decoration: none; }
.member-info a:hover { text-decoration: underline; }
.member-bio { padding-top: 24px; border-top: 1px solid #eee; }
.bio-content { font-size: 0.95rem; line-height: 1.7; color: #555; }
</style>
</div>
