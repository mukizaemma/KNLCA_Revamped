<?php

namespace App\Livewire\Admin\ContactMessages;

use App\Models\ContactMessage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = ContactMessage::query()
            ->orderByDesc('created_at');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('subject', 'like', '%' . $this->search . '%')
                    ->orWhere('message', 'like', '%' . $this->search . '%');
            });
        }

        $messages = $query->paginate(15);

        return view('livewire.admin.contact-messages.index', [
            'messages' => $messages,
        ]);
    }
}
