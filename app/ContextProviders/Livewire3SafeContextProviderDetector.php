<?php

namespace App\ContextProviders;

use Illuminate\Http\Request;
use Spatie\FlareClient\Context\ContextProvider;
use Spatie\FlareClient\Context\ContextProviderDetector;
use Spatie\LaravelIgnition\ContextProviders\LaravelConsoleContextProvider;
use Spatie\LaravelIgnition\ContextProviders\LaravelRequestContextProvider;

/**
 * Context provider detector that avoids Spatie's LaravelLivewireRequestContextProvider.
 * That provider depends on Livewire 2's ComponentRegistry, which does not exist in Livewire 3,
 * and causes "Target class [Livewire\Mechanisms\ComponentRegistry] does not exist" when an error occurs on a Livewire page.
 * For Livewire requests we use the standard LaravelRequestContextProvider instead.
 */
class Livewire3SafeContextProviderDetector implements ContextProviderDetector
{
    public function detectCurrentContext(): ContextProvider
    {
        if (app()->runningInConsole()) {
            return new LaravelConsoleContextProvider($_SERVER['argv'] ?? []);
        }

        $request = app(Request::class);

        return new LaravelRequestContextProvider($request);
    }
}
