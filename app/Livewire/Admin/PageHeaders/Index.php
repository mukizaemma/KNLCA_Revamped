<?php

namespace App\Livewire\Admin\PageHeaders;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.page-headers.index');
    }
}

