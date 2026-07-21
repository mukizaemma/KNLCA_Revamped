<?php

namespace App\Providers;

use App\Models\Partner;
use App\Models\ClinicalDepartment;
use App\Models\WebsiteSetting;
use App\Support\SiteContent;
use App\ContextProviders\Livewire3SafeContextProviderDetector;
use App\Renderers\Livewire3SafeErrorPageRenderer;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\FlareClient\Flare;
use Spatie\LaravelIgnition\Renderers\ErrorPageRenderer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function ($user, string $token) {
            $isAdmin = in_array($user->role, ['super_admin', 'website_admin'], true);
            $route = $isAdmin ? 'admin.password.reset' : 'password.reset';

            return url(route($route, [
                'token' => $token,
                'email' => $user->email,
            ], false));
        });

        View::composer('layouts.frontend', function ($view) {
            $settings = WebsiteSetting::first() ?? new WebsiteSetting;
            $view->with('websiteSettings', $settings);
            $view->with('academicPrograms', ClinicalDepartment::where('is_active', true)->orderBy('sort_order')->get());
            $view->with('siteContent', SiteContent::for($settings));
            $view->with('footerPartners', Partner::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get());
        });

        View::share('siteContent', SiteContent::for(WebsiteSetting::first() ?? new WebsiteSetting));

        // Use a Livewire-3-safe context detector so error pages don't try to resolve
        // Livewire 2's ComponentRegistry (which doesn't exist in Livewire 3).
        $this->app->afterResolving(Flare::class, function (Flare $flare) {
            $flare->setContextProviderDetector(new Livewire3SafeContextProviderDetector());
        });

        $this->app->bind(ErrorPageRenderer::class, Livewire3SafeErrorPageRenderer::class);
    }
}
