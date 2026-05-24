<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $authSettings = \App\Models\WebsiteSetting::first();
        $schoolName = $authSettings->company_name ?? config('app.name');
        $fontFamily = $authSettings->site_font_family ?? 'Poppins';
        $fontSlug = str_replace(' ', '+', $fontFamily);
        $fontHref = $authSettings->site_font_css_url ?? "https://fonts.googleapis.com/css2?family={$fontSlug}:wght@400;500;600;700&display=swap";
        $heroImage = $authSettings->home_background_image_path ?? $authSettings->cta_background_image_path ?? null;
    @endphp
    <title>{{ $title ?? 'Account' }} — {{ $schoolName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ $fontHref }}" rel="stylesheet">
    <link href="{{ asset('css/frontend.css') }}?v={{ file_exists(public_path('css/frontend.css')) ? filemtime(public_path('css/frontend.css')) : 1 }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}?v={{ file_exists(public_path('css/auth.css')) ? filemtime(public_path('css/auth.css')) : 1 }}" rel="stylesheet">
    @livewireStyles
</head>
<body class="auth-body" style="font-family: '{{ $fontFamily }}', system-ui, sans-serif;">
    <div class="auth-shell">
        <aside class="auth-shell__brand" @if($heroImage) style="background-image: url('{{ asset($heroImage) }}');" @endif>
            <div class="auth-shell__brand-overlay"></div>
            <div class="auth-shell__brand-content">
                <a href="{{ route('home') }}" class="auth-shell__logo">
                    @if($authSettings->logo_path ?? null)
                        <img src="{{ asset($authSettings->logo_path) }}" alt="{{ $schoolName }}">
                    @else
                        <span>{{ $schoolName }}</span>
                    @endif
                </a>
                @php
                    $authTagline = trim(strip_tags($authSettings->home_background_text ?? ''));
                    if ($authTagline === '') {
                        $authTagline = \App\Support\SiteContent::get($authSettings, 'global.topbar_tagline', '');
                    }
                @endphp
                @if($authTagline !== '')
                    <p class="auth-shell__tagline">{{ $authTagline }}</p>
                @endif
                <p class="auth-shell__welcome">Welcome back. Sign in to manage your account or explore our school community.</p>
                <a href="{{ route('home') }}" class="auth-shell__home-link">&larr; Back to website</a>
            </div>
        </aside>
        <main class="auth-shell__main">
            {{ $slot }}
        </main>
    </div>
    @livewireScripts
</body>
</html>
