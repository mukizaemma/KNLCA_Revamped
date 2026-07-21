<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public frontend (Livewire SPA-like with wire:navigate)
Route::get('/', \App\Livewire\Frontend\Home::class)->name('home');
Route::get('/about', \App\Livewire\Frontend\About::class)->name('about');
Route::redirect('/about/mission-vision', '/about?section=mission-vision')->name('about.mission-vision');
Route::redirect('/about/core-values', '/about?section=core-values')->name('about.core-values');
Route::redirect('/about/staff', '/about?section=staff')->name('about.staff');
Route::redirect('/about/history', '/about?section=history')->name('about.history');
Route::redirect('/about/our-schools', '/about?section=our-schools')->name('about.our-schools');
Route::redirect('/about/inquire', '/about?section=inquire')->name('about.inquire');
Route::redirect('/visit-school', '/about?section=inquire')->name('visit-school');
Route::get('/contact', \App\Livewire\Frontend\Contact::class)->name('contact');
Route::get('/departments', \App\Livewire\Frontend\Departments\Index::class)->name('departments.index');
Route::get('/departments/{department}', \App\Livewire\Frontend\Departments\Show::class)->name('departments.show');
Route::get('/leadership', \App\Livewire\Frontend\LeadershipTeam\Index::class)->name('leadership.index');
Route::get('/leadership/{member}/{slug?}', \App\Livewire\Frontend\LeadershipTeam\Show::class)->name('leadership.show');
Route::get('/gallery', \App\Livewire\Frontend\Gallery\Index::class)->name('gallery.index');
Route::get('/admissions', \App\Livewire\Frontend\Admissions::class)->name('admissions');
Route::get('/facilities', \App\Livewire\Frontend\Facilities::class)->name('facilities');
Route::get('/school-activities', \App\Livewire\Frontend\SchoolActivities\Index::class)->name('school-activities');
Route::get('/school-activities/{activity}', \App\Livewire\Frontend\SchoolActivities\Show::class)->name('school-activities.show');
Route::get('/careers', \App\Livewire\Frontend\Careers::class)->name('careers');
Route::get('/appointment', \App\Livewire\Frontend\Appointment::class)->name('appointment');
Route::get('/feedback', \App\Livewire\Frontend\FeedbackForm::class)->name('feedback');

// Public Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
    Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
    Route::get('/password/forgot', \App\Livewire\Auth\ForgotPassword::class)->name('password.request');
    Route::get('/password/reset/{token}', \App\Livewire\Auth\ResetPassword::class)->name('password.reset');
});

// Admin Authentication & Dashboard Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Auth (login/reset)
    Route::middleware('guest')->group(function () {
        Route::get('/login', \App\Livewire\Admin\Auth\Login::class)->name('login');
        Route::get('/password/forgot', \App\Livewire\Admin\Auth\ForgotPassword::class)->name('password.request');
        Route::get('/password/reset/{token}', \App\Livewire\Admin\Auth\ResetPassword::class)->name('password.reset');
    });

    // Admin area for school website management (Super Admin + Website Manager)
    Route::middleware(['auth', 'role:super_admin,website_admin'])->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');

        // School info, contacts, about, page headers (single page with tabs)
        Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('settings.index');

        // Home page slideshow (hero slides)
        Route::get('/sliders', \App\Livewire\Admin\Sliders\Index::class)->name('sliders.index');

        // School programs / curriculum (re-using departments component)
        Route::get('/programs', \App\Livewire\Admin\Departments\Index::class)->name('programs.index');

        // Facilities
        Route::get('/facilities', \App\Livewire\Admin\Facilities\Index::class)->name('facilities.index');

        // School activities (articles/blog)
        Route::get('/school-activities', \App\Livewire\Admin\SchoolActivities\Index::class)->name('school-activities.index');

        // School services
        Route::get('/services', \App\Livewire\Admin\Services\Index::class)->name('services.index');

        // Public-facing staff / leadership profiles
        Route::get('/staff', \App\Livewire\Admin\LeadershipTeam\Index::class)->name('staff.index');

        // Media gallery for school photos
        Route::get('/gallery', \App\Livewire\Admin\Gallery\Index::class)->name('gallery.index');

        // Contact messages from website contact form
        Route::get('/contact-messages', \App\Livewire\Admin\ContactMessages\Index::class)->name('contact-messages.index');

        // Student registrations (from public registration form)
        Route::get('/registrations', \App\Livewire\Admin\Registrations\Index::class)->name('registrations.index');

        // Admissions page content (process, first admission, transfer)
        Route::get('/admission-page', \App\Livewire\Admin\AdmissionPage::class)->name('admission-page.index');

        // Static page copy (headings, intros, home curriculum pillars, etc.)
        Route::get('/page-content', \App\Livewire\Admin\PageContent::class)->name('page-content.index');

        // Accreditation & partner logos (footer, etc.)
        Route::get('/partners', \App\Livewire\Admin\Partners\Index::class)->name('partners.index');

        // Editor image upload (for Summernote and other rich text fields)
        Route::post('/upload-editor-image', [\App\Http\Controllers\Admin\UploadEditorImageController::class, '__invoke'])->name('upload-editor-image');
    });

    // User management – Super Admin only (Website Manager should not access users)
    Route::middleware(['auth', 'role:super_admin'])->group(function () {
        Route::get('/users', \App\Livewire\Admin\Users\Index::class)->name('users.index');
    });
});

// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');
