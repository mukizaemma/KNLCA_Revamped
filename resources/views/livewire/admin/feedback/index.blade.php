@section('title', 'Customer Feedback')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">Customer Feedback & Ratings</h4>

            <div class="d-flex flex-wrap gap-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search name, email, phone, message..."
                    wire:model.debounce.300ms="search"
                    style="min-width: 240px;"
                >

                <select class="form-select form-select-sm" wire:model="categoryFilter">
                    <option value="all">All Categories</option>
                    <option value="overall">Overall</option>
                    <option value="department">Department</option>
                    <option value="service">Service</option>
                    <option value="restaurant">Restaurant</option>
                    <option value="facility">Facility</option>
                    <option value="staff">Staff</option>
                    <option value="other">Other</option>
                </select>

                <select class="form-select form-select-sm" wire:model="approvalFilter">
                    <option value="all">All Status</option>
                    <option value="approved">Approved only</option>
                    <option value="pending">Pending only</option>
                </select>

                {{-- No "create feedback" button here: feedback comes from public site.
                     Super admin could be given a separate tool if you ever need it. --}}
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-4 mb-3">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fa fa-chart-pie me-2 text-primary"></i>
                            Summary by Category
                        </h5>

                        @if($stats->isEmpty())
                            <p class="text-muted mb-0">No feedback yet.</p>
                        @else
                            <canvas id="feedbackCategoryChart" height="200"></canvas>
                        @endif>
                    </div>
                </div>

                @if($editingId)
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Update Feedback Status</h6>

                            <form wire:submit.prevent="saveMeta">
                                <div class="mb-2">
                                    <label class="form-label">Display Date</label>
                                    <input
                                        type="date"
                                        class="form-control form-control-sm"
                                        wire:model.defer="feedback_date"
                                    >
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="is_approved_switch"
                                        wire:model="is_approved"
                                    >
                                    <label class="form-check-label" for="is_approved_switch">
                                        Approved for website
                                    </label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="is_featured_switch"
                                        wire:model="is_featured"
                                    >
                                    <label class="form-check-label" for="is_featured_switch">
                                        Mark as featured
                                    </label>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-secondary"
                                        wire:click="$set('editingId', null)"
                                    >
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-save me-1"></i>Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Feedback List</h6>
                    <button
                        class="btn btn-sm btn-outline-secondary"
                        onclick="window.print()"
                    >
                        <i class="fa fa-print me-1"></i>Print
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Visitor</th>
                                <th>Rated</th>
                                <th>Rating /10</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feedbackItems as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->full_name ?? 'Anonymous' }}</strong><br>
                                        <small class="text-muted">
                                            {{ $item->email }} {{ $item->phone ? ' | '.$item->phone : '' }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary text-capitalize">
                                            {{ $item->rating_category }}
                                        </span>
                                        @if($item->rated_target_label)
                                            <br>
                                            <small class="text-muted">{{ $item->rated_target_label }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!is_null($item->rating_out_of_10))
                                            <strong>{{ $item->rating_out_of_10 }}</strong>/10
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_approved)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ optional($item->feedback_date ?? $item->created_at)->format('Y-m-d') }}
                                    </td>
                                    <td class="text-end">
                                        <button
                                            class="btn btn-sm btn-outline-primary me-1"
                                            wire:click="editMeta({{ $item->id }})"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        @if($canManageContent)
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                wire:click="delete({{ $item->id }})"
                                                onclick="return confirm('Delete this feedback entry?')"
                                            >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <strong>Feedback:</strong>
                                        <div class="small mb-1">
                                            {!! nl2br(e(Str::limit($item->message, 400))) !!}
                                        </div>
                                        @if($item->recommendations)
                                            <strong>Recommendations:</strong>
                                            <div class="small text-muted">
                                                {!! nl2br(e(Str::limit($item->recommendations, 400))) !!}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No feedback found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-2">
                    {{ $feedbackItems->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @if($stats->isNotEmpty())
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctx = document.getElementById('feedbackCategoryChart');
                    if (!ctx) return;

                    const stats = @json($stats);
                    const labels = stats.map(s => s.rating_category);
                    const totals = stats.map(s => s.total);

                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: totals,
                                backgroundColor: [
                                    '#0d6efd', '#198754', '#ffc107',
                                    '#dc3545', '#6610f2', '#20c997', '#6c757d'
                                ],
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                });
            </script>
        @endif
    @endpush
</div>

