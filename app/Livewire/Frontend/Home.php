<?php

namespace App\Livewire\Frontend;

use App\Models\ClinicalDepartment;
use App\Models\HomeSlider;
use App\Models\MediaGalleryItem;
use App\Models\WebsiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Home extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        $settings = WebsiteSetting::first();
        $sliders = HomeSlider::where('is_active', true)->orderBy('sort_order')->get();
        $departments = ClinicalDepartment::where('is_active', true)->orderBy('sort_order')->get();
        $galleryImages = MediaGalleryItem::query()
            ->where('is_active', true)
            ->where('type', 'image')
            ->whereNotNull('image_path')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $whyChooseCards = [];
        if ($settings?->about_value_cards) {
            $whyChooseCards = is_string($settings->about_value_cards)
                ? json_decode($settings->about_value_cards, true)
                : $settings->about_value_cards;
            $whyChooseCards = is_array($whyChooseCards)
                ? array_filter($whyChooseCards, fn ($c) => ! empty($c['name'] ?? null))
                : [];
        }

        return view('livewire.frontend.home', [
            'settings' => $settings,
            'sliders' => $sliders,
            'departments' => $departments,
            'galleryImages' => $galleryImages,
            'whyChooseCards' => $whyChooseCards,
        ]);
    }
}
