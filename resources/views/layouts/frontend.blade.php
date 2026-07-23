<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ ($websiteSettings->company_name ?? config('app.name')) . ' — ' . ($siteContent['global']['meta_description'] ?? '') }}">
    <title>@yield('title', $websiteSettings->company_name ?? config('app.name'))</title>

    {{-- Preload critical assets (fonts) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @php
        $primaryFontFamily = $websiteSettings->site_font_family ?: 'Poppins';
        $googleFontHref = $websiteSettings->site_font_css_url;
        if (!$googleFontHref) {
            $fontSlug = str_replace(' ', '+', $primaryFontFamily);
            $googleFontHref = "https://fonts.googleapis.com/css2?family={$fontSlug}:wght@300;400;500;600;700&display=swap";
        }
    @endphp
    <link rel="preload" href="{{ $googleFontHref }}" as="style">
    <link href="{{ $googleFontHref }}" rel="stylesheet">

    <link href="{{ asset('css/frontend.css') }}?v={{ file_exists(public_path('css/frontend.css')) ? filemtime(public_path('css/frontend.css')) : 1 }}" rel="stylesheet">
    <link href="{{ asset('css/pages.css') }}?v={{ file_exists(public_path('css/pages.css')) ? filemtime(public_path('css/pages.css')) : 1 }}" rel="stylesheet">
    @stack('styles')
    @livewireStyles
</head>
<body style="font-family: '{{ $primaryFontFamily }}', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
    {{-- Site loader --}}
    <div id="site-loader" class="site-loader" aria-live="polite" aria-busy="true">
        <div class="loader-school" aria-hidden="true">
            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                <path class="loader-school__book" d="M12 20h40v32H12V20z"/>
                <path class="loader-school__cap" d="M8 20l24-12 24 12v4H8v-4z"/>
            </svg>
        </div>
        <span class="loader-school__text">Loading</span>
    </div>

    <div class="container">
        {{-- Navbar — single-row navy bar --}}
        @php
            $schoolName = $websiteSettings->company_name ?? config('app.name');
            $brandTitle = 'New Life';
            $brandSubtitle = $schoolName;
            if (preg_match('/^(New Life)\s+(.+)$/i', trim($schoolName), $m)) {
                $brandTitle = $m[1];
                $brandSubtitle = $m[2];
            }
        @endphp
        <nav class="navbar" x-data="{ mobileOpen: false }" @keydown.escape.window="mobileOpen = false">
            <div class="navbar__inner">
                <a href="{{ route('home') }}" class="navbar-brand" wire:navigate @click="mobileOpen = false">
                    @if($websiteSettings->logo_path ?? null)
                        <img src="{{ asset($websiteSettings->logo_path) }}" alt="" class="navbar-brand__logo">
                    @endif
                    <span class="navbar-brand__text">
                        <span class="navbar-brand__title">{{ $brandTitle }}</span>
                        <span class="navbar-brand__subtitle">{{ $brandSubtitle }}</span>
                    </span>
                </a>

                <div class="navbar-links">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" wire:navigate>Home</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" wire:navigate>About us</a>
                    <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}" wire:navigate>Academics</a>
                    <a href="{{ route('admissions') }}" class="nav-link {{ request()->routeIs('admissions') ? 'active' : '' }}" wire:navigate>Admissions</a>
                    <a href="{{ route('facilities') }}" class="nav-link {{ request()->routeIs('facilities') ? 'active' : '' }}" wire:navigate>Facilities</a>
                    <a href="{{ route('school-activities') }}" class="nav-link nav-link--secondary {{ request()->routeIs('school-activities*') ? 'active' : '' }}" wire:navigate>Activities</a>
                    <a href="{{ route('careers') }}" class="nav-link nav-link--secondary {{ request()->routeIs('careers') ? 'active' : '' }}" wire:navigate>Careers</a>
                    @if($websiteSettings->gallery_external_url ?? null)
                        <a href="{{ $websiteSettings->gallery_external_url }}" class="nav-link" target="_blank" rel="noopener noreferrer">Gallery</a>
                    @else
                        <a href="{{ route('gallery.index') }}" class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" wire:navigate>Gallery</a>
                    @endif
                </div>

                <div class="navbar-actions">
                    <a href="{{ route('appointment') }}" class="btn-appointment {{ request()->routeIs('appointment') ? 'active' : '' }}" wire:navigate>Register</a>
                    <button type="button" class="navbar-toggle" :aria-expanded="mobileOpen" aria-controls="navbar-mobile" aria-label="Open menu" @click="mobileOpen = !mobileOpen">
                        <span class="navbar-toggle__bar"></span>
                        <span class="navbar-toggle__bar"></span>
                        <span class="navbar-toggle__bar"></span>
                    </button>
                </div>
            </div>

            <div id="navbar-mobile" class="navbar-mobile-panel" :class="{ 'is-open': mobileOpen }" x-show="mobileOpen" x-cloak @click.outside="mobileOpen = false">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" wire:navigate @click="mobileOpen = false">Home</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}" wire:navigate @click="mobileOpen = false">About us</a>
                <a href="{{ route('departments.index') }}" wire:navigate @click="mobileOpen = false">Academics</a>
                <a href="{{ route('admissions') }}" wire:navigate @click="mobileOpen = false">Admissions</a>
                <a href="{{ route('facilities') }}" wire:navigate @click="mobileOpen = false">Facilities</a>
                <a href="{{ route('school-activities') }}" wire:navigate @click="mobileOpen = false">School activities</a>
                <a href="{{ route('careers') }}" wire:navigate @click="mobileOpen = false">Careers</a>
                @if($websiteSettings->gallery_external_url ?? null)
                    <a href="{{ $websiteSettings->gallery_external_url }}" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false">Gallery</a>
                @else
                    <a href="{{ route('gallery.index') }}" wire:navigate @click="mobileOpen = false">Gallery</a>
                @endif
                <a href="{{ url('/about#inquire') }}" @click="mobileOpen = false">Contact us</a>
                <a href="{{ route('appointment') }}" class="btn-appointment" wire:navigate @click="mobileOpen = false">Register</a>
            </div>
        </nav>

        {{-- Main content (Livewire slot) --}}
        <main class="main-content">
            {{ $slot ?? '' }}
        </main>

        {{-- Footer --}}
        <footer class="footer">
            @php
                $footerVision = trim(strip_tags($websiteSettings->vision ?? ''));
                if ($footerVision === '') {
                    $footerVision = trim(strip_tags($websiteSettings->mission ?? ''));
                }
                $footerSchool = $websiteSettings->company_name ?? config('app.name');
            @endphp
            <div class="footer__main">
                <div class="footer__col footer__col--brand">
                    <a href="{{ route('home') }}" wire:navigate class="footer__logo">
                        @if($websiteSettings->logo_path ?? null)
                            <img src="{{ asset($websiteSettings->logo_path) }}" alt="{{ $footerSchool }}" class="footer__logo-img">
                        @else
                            <span class="footer__logo-text">{{ $footerSchool }}</span>
                        @endif
                    </a>
                    <p class="footer__brand-name">{{ $footerSchool }}</p>
                    @if($footerVision !== '')
                        <p class="footer__vision">{{ \Illuminate\Support\Str::limit($footerVision, 160) }}</p>
                    @endif
                    <x-footer-social :settings="$websiteSettings" class="footer__social--brand" />
                </div>

                <div class="footer__col footer__col--menu">
                    <h3 class="footer__heading">{{ $siteContent['global']['footer_menu_heading'] ?? 'Our School' }}</h3>
                    <nav class="footer__nav" aria-label="Footer">
                        <a href="{{ route('about') }}" wire:navigate>About us</a>
                        <a href="{{ route('departments.index') }}" wire:navigate>Academics</a>
                        <a href="{{ route('admissions') }}" wire:navigate>Admissions</a>
                        <a href="{{ route('facilities') }}" wire:navigate>Facilities</a>
                        <a href="{{ route('school-activities') }}" wire:navigate>Activities</a>
                        <a href="{{ route('careers') }}" wire:navigate>Careers</a>
                        @if($websiteSettings->gallery_external_url ?? null)
                            <a href="{{ $websiteSettings->gallery_external_url }}" target="_blank" rel="noopener noreferrer">Gallery</a>
                        @else
                            <a href="{{ route('gallery.index') }}" wire:navigate>Gallery</a>
                        @endif
                        <a href="{{ route('contact') }}" wire:navigate>Contact</a>
                    </nav>
                </div>

                <div class="footer__col footer__col--partners">
                    <x-partners-panel :partners="$footerPartners" variant="footer" />
                </div>

                <div class="footer__col footer__col--contact">
                    <h3 class="footer__heading">Get in touch</h3>
                    <div class="footer__contacts">
                        @if($websiteSettings->address ?? null)
                            <div class="footer__contact-item">
                                <span class="footer__contact-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </span>
                                <span>{{ $websiteSettings->address }}</span>
                            </div>
                        @endif
                        @if($websiteSettings->phone_reception ?? $websiteSettings->phone_urgency ?? null)
                            <div class="footer__contact-item">
                                <span class="footer__contact-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </span>
                                <a href="tel:{{ $websiteSettings->phone_reception ?? $websiteSettings->phone_urgency }}">{{ $websiteSettings->phone_reception ?? $websiteSettings->phone_urgency }}</a>
                            </div>
                        @endif
                        @if($websiteSettings->email ?? null)
                            <div class="footer__contact-item">
                                <span class="footer__contact-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                </span>
                                <a href="mailto:{{ $websiteSettings->email }}">{{ $websiteSettings->email }}</a>
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('appointment') }}" class="footer__register-btn" wire:navigate>Register</a>
                </div>
            </div>
            <div class="footer__bottom">
                <div class="footer__copyright">
                    Copyright © {{ date('Y') }} {{ $footerSchool }}. All rights reserved.
                </div>
                <div class="footer__developed">
                    {!! $siteContent['global']['developer_credit'] ?? 'Developed by <a href="https://iremetech.com" target="_blank" rel="noopener noreferrer">Ireme Technologies</a>' !!}
                </div>
            </div>
        </footer>

        {{-- Floating WhatsApp icon (left lower side) --}}
        @if($websiteSettings->phone_whatsapp ?? null)
            @php
                $waNumber = preg_replace('/[^0-9]/', '', $websiteSettings->phone_whatsapp);
            @endphp
            @if($waNumber)
                <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" class="whatsapp-float" aria-label="Chat on WhatsApp">
                    <svg viewBox="0 0 32 32" fill="currentColor" width="28" height="28" aria-hidden="true">
                        <path d="M16 0C7.164 0 0 7.164 0 16c0 2.825.736 5.48 2.024 7.784L.056 31.68l8.064-2.112A15.92 15.92 0 0016 32c8.836 0 16-7.164 16-16S24.836 0 16 0zm0 29.333c-2.616 0-5.084-.696-7.22-1.912l-.508-.3-5.264 1.38 1.408-5.14-.332-.528A13.22 13.22 0 012.667 16c0-7.364 5.969-13.333 13.333-13.333S29.333 8.636 29.333 16 23.364 29.333 16 29.333zm7.316-9.964c-.392-.196-2.316-1.144-2.676-1.272-.36-.128-.624-.196-.888.196-.264.392-1.024 1.272-1.256 1.532-.232.26-.464.292-.856.096-.392-.196-1.656-.612-3.156-1.948-1.168-1.04-1.952-2.324-2.18-2.716-.228-.392-.024-.604.172-.796.176-.176.392-.46.588-.688.196-.228.26-.392.392-.656.132-.264.066-.492-.032-.688-.1-.196-.888-2.14-1.216-2.928-.324-.776-.656-.672-.888-.684l-.756-.016c-.264 0-.688.096-1.048.476-.36.38-1.376 1.344-1.376 3.276 0 1.932 1.408 3.036 1.604 3.244.196.208 2.776 4.244 6.724 5.828.936.376 1.668.6 2.236.768.936.272 1.788.232 2.46.14.752-.104 2.316-.948 2.64-1.86.324-.912.324-1.692.228-1.86-.096-.168-.36-.264-.752-.46z"/>
                    </svg>
                </a>
            @endif
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var loader = document.getElementById('site-loader');
            if (loader) loader.classList.add('hidden');

            if (window.Livewire) {
                Livewire.on('swal', (data = {}) => {
                    Swal.fire({
                        toast: true,
                        position: data.position || 'top-end',
                        timer: data.timer ?? 2800,
                        timerProgressBar: true,
                        showConfirmButton: data.showConfirmButton ?? false,
                        icon: data.icon || 'success',
                        title: data.title || 'Done',
                        text: data.text || ''
                    });
                });
            }
        });
        document.addEventListener('livewire:navigated', function() {
            var loader = document.getElementById('site-loader');
            if (loader) loader.classList.add('hidden');
        });
    </script>
    @livewireScripts
    <script src="{{ asset('js/image-upload-compress.js') }}?v={{ file_exists(public_path('js/image-upload-compress.js')) ? filemtime(public_path('js/image-upload-compress.js')) : 1 }}"></script>
    @stack('scripts')
</body>
</html>
