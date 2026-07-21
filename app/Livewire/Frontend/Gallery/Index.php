<?php

namespace App\Livewire\Frontend\Gallery;

use App\Models\MediaGalleryItem;
use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        $header = PageHeader::where('page_key', 'gallery')->first();
        $items = MediaGalleryItem::where('is_active', true)
            ->where('type', 'image')
            ->whereNotNull('image_path')
            ->orderBy('sort_order')
            ->get();

        $galleryLightboxImages = $items->map(fn ($i) => [
            'src' => asset($i->image_path),
            'alt' => $i->title ?? 'Gallery',
            'caption' => strip_tags($i->caption ?? ''),
            'title' => $i->title ?? '',
        ])->values();

        return view('livewire.frontend.gallery.index', [
            'header' => $header,
            'items' => $items,
            'galleryLightboxImages' => $galleryLightboxImages,
        ]);
    }
}
