<?php

namespace App\Livewire\Frontend\About;

use App\Livewire\Frontend\Concerns\LoadsPageHeader;
use App\Models\WebsiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class OurSchools extends Component
{
    use LoadsPageHeader;

    #[Layout('layouts.frontend')]
    public function render()
    {
        $settings = WebsiteSetting::first();
        $affiliateSchools = [];
        if ($settings?->affiliate_schools) {
            $affiliateSchools = is_string($settings->affiliate_schools)
                ? json_decode($settings->affiliate_schools, true)
                : $settings->affiliate_schools;
            $affiliateSchools = is_array($affiliateSchools)
                ? array_filter($affiliateSchools, fn ($s) => ! empty($s['name'] ?? null))
                : [];
        }

        return view('livewire.frontend.about.our-schools', [
            'header' => $this->pageHeader('about_schools'),
            'affiliateSchools' => $affiliateSchools,
        ]);
    }
}
