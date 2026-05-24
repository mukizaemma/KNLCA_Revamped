<?php

namespace App\Livewire\Admin\Feedback;

use App\Models\CustomerFeedback;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categoryFilter = 'all';
    public string $approvalFilter = 'all';

    public ?int $editingId = null;
    public ?string $feedback_date = null;
    public ?bool $is_approved = null;
    public ?bool $is_featured = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updatingApprovalFilter(): void
    {
        $this->resetPage();
    }

    protected function canManageContent(): bool
    {
        return auth()->user()?->role === 'super_admin';
    }

    public function editMeta(int $feedbackId): void
    {
        $feedback = CustomerFeedback::findOrFail($feedbackId);

        $this->editingId = $feedback->id;
        $this->feedback_date = optional($feedback->feedback_date)->format('Y-m-d');
        $this->is_approved = $feedback->is_approved;
        $this->is_featured = $feedback->is_featured;
    }

    public function saveMeta(): void
    {
        if (!$this->editingId) {
            return;
        }

        $feedback = CustomerFeedback::findOrFail($this->editingId);

        // Both super_admin and website_admin can update approval + featured + display date
        $feedback->feedback_date = $this->feedback_date ?: $feedback->created_at;
        $feedback->is_approved = (bool) $this->is_approved;
        $feedback->is_featured = (bool) $this->is_featured;

        if ($feedback->is_approved && !$feedback->approved_at) {
            $feedback->approved_at = now();
        }

        $feedback->save();

        session()->flash('success', 'Feedback metadata updated.');
        $this->reset('editingId', 'feedback_date', 'is_approved', 'is_featured');
    }

    public function delete(int $feedbackId): void
    {
        // Only super_admin can delete feedback
        if (!$this->canManageContent()) {
            abort(403, 'Only super admin can delete feedback.');
        }

        CustomerFeedback::findOrFail($feedbackId)->delete();
        session()->flash('success', 'Feedback deleted successfully.');
    }

    public function getFeedbackProperty()
    {
        $query = CustomerFeedback::query()
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('full_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%')
                        ->orWhere('message', 'like', '%' . $this->search . '%')
                        ->orWhere('rated_target_label', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter !== 'all', function ($q) {
                $q->where('rating_category', $this->categoryFilter);
            })
            ->when($this->approvalFilter !== 'all', function ($q) {
                if ($this->approvalFilter === 'approved') {
                    $q->where('is_approved', true);
                } elseif ($this->approvalFilter === 'pending') {
                    $q->where('is_approved', false);
                }
            });

        return $query->orderByDesc('created_at')->paginate(15);
    }

    public function render()
    {
        $stats = CustomerFeedback::selectRaw(
            'rating_category, COUNT(*) as total, AVG(rating_out_of_10) as avg_rating'
        )
            ->groupBy('rating_category')
            ->get();

        return view('livewire.admin.feedback.index', [
            'feedbackItems' => $this->feedback,
            'stats' => $stats,
            'canManageContent' => $this->canManageContent(),
        ]);
    }
}

