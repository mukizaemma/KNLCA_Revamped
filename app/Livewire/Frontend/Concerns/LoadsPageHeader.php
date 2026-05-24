<?php

namespace App\Livewire\Frontend\Concerns;

use App\Models\PageHeader;

trait LoadsPageHeader
{
    protected function pageHeader(string $key, ?string $fallbackKey = 'about'): ?PageHeader
    {
        return PageHeader::where('page_key', $key)->first()
            ?? ($fallbackKey ? PageHeader::where('page_key', $fallbackKey)->first() : null);
    }
}
