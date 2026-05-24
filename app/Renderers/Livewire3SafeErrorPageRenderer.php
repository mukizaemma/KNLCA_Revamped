<?php

namespace App\Renderers;

use App\ContextProviders\Livewire3SafeContextProviderDetector;
use Spatie\ErrorSolutions\Contracts\SolutionProviderRepository;
use Spatie\FlareClient\Flare;
use Spatie\Ignition\Config\IgnitionConfig;
use Spatie\Ignition\Ignition;
use Spatie\LaravelIgnition\Renderers\ErrorPageRenderer as BaseErrorPageRenderer;
use Spatie\LaravelIgnition\Solutions\SolutionTransformers\LaravelSolutionTransformer;
use Spatie\LaravelIgnition\Support\LaravelDocumentationLinkFinder;
use Throwable;

/**
 * Error page renderer that uses a Livewire-3-safe context detector.
 * Avoids Spatie's default LaravelLivewireRequestContextProvider which depends on
 * Livewire 2's ComponentRegistry and causes "Target class does not exist" on Livewire pages.
 */
class Livewire3SafeErrorPageRenderer extends BaseErrorPageRenderer
{
    public function render(Throwable $throwable): void
    {
        $viteJsAutoRefresh = '';

        if (class_exists('Illuminate\Foundation\Vite')) {
            $vite = app(\Illuminate\Foundation\Vite::class);

            if (is_file($vite->hotFile())) {
                $viteJsAutoRefresh = $vite->__invoke([]);
            }
        }

        app(Ignition::class)
            ->resolveDocumentationLink(
                fn (Throwable $t) => (new LaravelDocumentationLinkFinder())->findLinkForThrowable($t)
            )
            ->setFlare(app(Flare::class))
            ->setConfig(app(IgnitionConfig::class))
            ->setSolutionProviderRepository(app(SolutionProviderRepository::class))
            ->setContextProviderDetector(new Livewire3SafeContextProviderDetector())
            ->setSolutionTransformerClass(LaravelSolutionTransformer::class)
            ->applicationPath(base_path())
            ->addCustomHtmlToHead($viteJsAutoRefresh)
            ->renderException($throwable);
    }
}
