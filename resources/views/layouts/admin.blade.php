<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('templates/admin/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('templates/admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('templates/admin/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet (uses hospital brand colors via CSS variables) -->
    <link href="{{ asset('templates/admin/css/style.css') }}" rel="stylesheet">

    <!-- Summernote WYSIWYG for long text fields -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
    
    @livewireStyles
    @stack('styles')
</head>
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="{{ route('admin.dashboard') }}" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>{{ config('app.name') }}</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="{{ asset('templates/admin/img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                        <span>
                            @if(Auth::user()->isSuperAdmin())
                                Super Admin
                            @elseif(Auth::user()->role === 'website_admin')
                                Website Manager
                            @else
                                {{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}
                            @endif
                        </span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                    </a>

                    {{-- School setup --}}
                    <a href="{{ route('admin.settings.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="fa fa-school me-2"></i>School Info
                    </a>
                    <a href="{{ route('admin.sliders.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                        <i class="fa fa-film me-2"></i>Home Slides
                    </a>

                    {{-- School content --}}
                    <a href="{{ route('admin.programs.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}">
                        <i class="fa fa-sitemap me-2"></i>Programs
                    </a>
                    <a href="{{ route('admin.facilities.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}">
                        <i class="fa fa-building me-2"></i>Facilities
                    </a>
                    <a href="{{ route('admin.school-activities.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.school-activities.*') ? 'active' : '' }}">
                        <i class="fa fa-newspaper me-2"></i>School Activities
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <i class="fa fa-chalkboard-teacher me-2"></i>Services
                    </a>
                    <a href="{{ route('admin.staff.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                        <i class="fa fa-users me-2"></i>Staff
                    </a>
                    <a href="{{ route('admin.gallery.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                        <i class="fa fa-images me-2"></i>Gallery
                    </a>
                    <a href="{{ route('admin.contact-messages.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
                        <i class="fa fa-envelope me-2"></i>Contact Messages
                    </a>
                    <a href="{{ route('admin.registrations.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">
                        <i class="fa fa-user-graduate me-2"></i>Registrations
                    </a>
                    <a href="{{ route('admin.admission-page.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.admission-page.*') ? 'active' : '' }}">
                        <i class="fa fa-file-alt me-2"></i>Admissions Page
                    </a>
                    <a href="{{ route('admin.page-content.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.page-content.*') ? 'active' : '' }}">
                        <i class="fa fa-align-left me-2"></i>Page Content
                    </a>
                    <a href="{{ route('admin.partners.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                        <i class="fa fa-handshake me-2"></i>Partners
                    </a>

                    {{-- Admin users – only visible to Super Admin --}}
                    @if(Auth::user()->isSuperAdmin())
                        <a href="{{ route('admin.users.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fa fa-user-shield me-2"></i>Admin Users
                        </a>
                    @endif
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="{{ route('admin.dashboard') }}" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="{{ asset('templates/admin/img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <hr class="dropdown-divider">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Content Area Start -->
            <div class="container-fluid pt-4 px-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Support both classic Blade (@section("content")) and Livewire 3 layouts ($slot) --}}
                @if (!empty(trim($__env->yieldContent('content'))))
                    @yield('content')
                @elseif (isset($slot))
                    {{ $slot }}
                @endif
            </div>
            <!-- Content Area End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">{{ config('app.name') }}</a>, All Right Reserved.
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('templates/admin/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('templates/admin/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('templates/admin/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('templates/admin/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('templates/admin/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('templates/admin/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('templates/admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('templates/admin/js/main.js') }}"></script>

    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireScripts
    @stack('scripts')

    <script>
        // Global SweetAlert handler for Livewire events
        document.addEventListener('DOMContentLoaded', function () {
            if (window.Livewire) {
                Livewire.on('swal', (data = {}) => {
                    Swal.fire({
                        toast: true,
                        position: data.position || 'top-end',
                        timer: data.timer ?? 2600,
                        timerProgressBar: true,
                        showConfirmButton: data.showConfirmButton ?? false,
                        icon: data.icon || 'success',
                        title: data.title || 'Success',
                        text: data.text || ''
                    });
                });
            }
        });

        (function () {
            const getJq = () => window.jQuery || window.$;

            const isVisible = (el) => !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length);

            const destroySummernote = (el, $jq) => {
                if (!el.classList.contains('is-summernote-init')) {
                    return;
                }
                try {
                    $jq(el).summernote('destroy');
                } catch (e) {}
                el.classList.remove('is-summernote-init');
            };

            const destroyAllSummernote = () => {
                const $jq = getJq();
                if (!$jq || !$jq.fn || typeof $jq.fn.summernote === 'undefined') {
                    return;
                }
                document.querySelectorAll('textarea.summernote').forEach((el) => destroySummernote(el, $jq));
            };

            const syncSummernoteToLivewire = () => {
                const $jq = getJq();
                if (!$jq) return;
                document.querySelectorAll('textarea.summernote.is-summernote-init').forEach((el) => {
                    try {
                        const code = $jq(el).summernote('code');
                        if (code !== el.value) {
                            el.value = code;
                            el.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    } catch (e) {}
                });
            };

            const initSummernote = () => {
                const $jq = getJq();
                if (!$jq || !$jq.fn || typeof $jq.fn.summernote === 'undefined') {
                    return;
                }

                document.querySelectorAll('textarea.summernote').forEach((el) => {
                    if (!isVisible(el)) {
                        destroySummernote(el, $jq);
                        return;
                    }
                    if (el.classList.contains('is-summernote-init')) {
                        return;
                    }

                    const initial = el.value || '';
                    const height = parseInt(el.dataset.summernoteHeight || '280', 10);

                    $jq(el).summernote({
                        height: height,
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['insert', ['link', 'picture']],
                            ['view', ['codeview']]
                        ],
                        callbacks: {
                            onInit: function () {
                                if (initial) {
                                    $jq(el).summernote('code', initial);
                                }
                            },
                            onChange: function (contents) {
                                el.value = contents;
                                el.dispatchEvent(new Event('input', { bubbles: true }));
                            },
                            onBlur: function () {
                                el.dispatchEvent(new Event('change', { bubbles: true }));
                            },
                            onImageUpload: function (files) {
                                const editor = $jq(this);
                                const data = new FormData();
                                data.append('file', files[0]);
                                data.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                                fetch('{{ route("admin.upload-editor-image") }}', {
                                    method: 'POST',
                                    body: data,
                                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                                }).then(function (r) { return r.json(); }).then(function (res) {
                                    editor.summernote('insertImage', res.url);
                                }).catch(function () {
                                    alert('Image upload failed.');
                                });
                            }
                        }
                    });

                    el.classList.add('is-summernote-init');
                });
            };

            const refreshSummernote = () => {
                destroyAllSummernote();
                requestAnimationFrame(initSummernote);
            };

            const boot = () => {
                refreshSummernote();

                if (window.Livewire && typeof Livewire.hook === 'function') {
                    Livewire.hook('message.processed', () => refreshSummernote());
                }
            };

            document.addEventListener('submit', syncSummernoteToLivewire, true);
            document.addEventListener('click', function (e) {
                const btn = e.target.closest('[wire\\:click*="save"], [wire\\:click*="Save"]');
                if (btn) {
                    syncSummernoteToLivewire();
                }
            }, true);

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', boot);
            } else {
                boot();
            }

            document.addEventListener('livewire:init', boot);
            document.addEventListener('livewire:navigated', refreshSummernote);
        })();
    </script>
</body>
</html>
