@section('title', 'School Dashboard')

<div>
    <!-- Top KPI Cards -->
    <div class="row g-4">
        <!-- Programs -->
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.programs.index') }}" class="text-decoration-none">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 h-100">
                    <i class="fa fa-sitemap fa-3x text-primary"></i>
                    <div class="ms-3 text-end">
                        <p class="mb-1 text-muted text-uppercase small">Programs / Curriculum</p>
                        <h4 class="mb-0 text-dark">{{ $programCount }}</h4>
                        <small class="text-primary">Manage programs <i class="fa fa-arrow-right ms-1"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Services -->
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.services.index') }}" class="text-decoration-none">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 h-100">
                    <i class="fa fa-chalkboard-teacher fa-3x text-primary"></i>
                    <div class="ms-3 text-end">
                        <p class="mb-1 text-muted text-uppercase small">Services</p>
                        <h4 class="mb-0 text-dark">{{ $serviceCount }}</h4>
                        <small class="text-primary">Manage services <i class="fa fa-arrow-right ms-1"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Staff -->
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.staff.index') }}" class="text-decoration-none">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 h-100">
                    <i class="fa fa-users fa-3x text-primary"></i>
                    <div class="ms-3 text-end">
                        <p class="mb-1 text-muted text-uppercase small">Staff Profiles</p>
                        <h4 class="mb-0 text-dark">{{ $staffCount }}</h4>
                        <small class="text-primary">Manage staff <i class="fa fa-arrow-right ms-1"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Contact messages -->
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.contact-messages.index') }}" class="text-decoration-none">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 h-100">
                    <i class="fa fa-envelope fa-3x text-primary"></i>
                    <div class="ms-3 text-end">
                        <p class="mb-1 text-muted text-uppercase small">Contact Messages</p>
                        <h4 class="mb-0 text-dark">{{ $contactMessageCount }}</h4>
                        <small class="text-primary">View messages <i class="fa fa-arrow-right ms-1"></i></small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Welcome / Helper Text -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="bg-light rounded p-4">
                <h4 class="mb-2">Welcome to {{ config('app.name') }} School Website Admin</h4>
                <p class="mb-0 text-muted">
                    Use the cards above to quickly jump into managing programs, services, staff, and contact messages
                    for your school website.
                </p>
            </div>
        </div>
    </div>
</div>
