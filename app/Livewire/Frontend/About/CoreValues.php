<?php

namespace App\Livewire\Frontend\About;

use App\Livewire\Frontend\Concerns\LoadsPageHeader;
use App\Models\WebsiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CoreValues extends Component
{
    use LoadsPageHeader;

    #[Layout('layouts.frontend')]
    public function render()
    {
        $settings = WebsiteSetting::first();
        $valueCards = [];
        if ($settings?->about_value_cards) {
            $valueCards = is_array($settings->about_value_cards)
                ? $settings->about_value_cards
                : json_decode($settings->about_value_cards, true);
            $valueCards = is_array($valueCards)
                ? array_filter($valueCards, fn ($c) => ! empty($c['name'] ?? null))
                : [];
        }

        return view('livewire.frontend.about.core-values', [
            'header' => $this->pageHeader('about_values'),
            'settings' => $settings,
            'valueCards' => $valueCards,
        ]);
    }
}
