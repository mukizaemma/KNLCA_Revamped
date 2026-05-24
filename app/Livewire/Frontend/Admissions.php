<?php

namespace App\Livewire\Frontend;

use App\Models\AdmissionPage as AdmissionPageModel;
use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontend')]
class Admissions extends Component
{
    public function render()
    {
        $header = PageHeader::where('page_key', 'admissions')->first();
        $content = AdmissionPageModel::content();

        return view('livewire.frontend.admissions', [
            'header' => $header,
            'content' => $content,
        ]);
    }
}
