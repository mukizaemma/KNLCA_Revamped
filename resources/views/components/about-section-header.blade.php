@props(['label' => null, 'title', 'subtitle' => null, 'centered' => true])

<div class="about-section-header {{ $centered ? 'about-section-header--center' : '' }}">
    @if($label)
        <p class="section-heading">{{ $label }}</p>
    @endif
    <h2 class="section-title">{{ $title }}</h2>
    @if($subtitle)
        <p class="section-sub {{ $centered ? 'section-sub--center' : '' }}">{{ $subtitle }}</p>
    @endif
</div>
