<?php

namespace App\Providers;

use App\Models\Partner;
use App\Models\ClinicalDepartment;
use App\Models\WebsiteSetting;
use App\Support\SiteContent;
use App\ContextProviders\Livewire3SafeContextProviderDetector;
use App\Renderers\Livewire3SafeErrorPageRenderer;
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

    }
}
