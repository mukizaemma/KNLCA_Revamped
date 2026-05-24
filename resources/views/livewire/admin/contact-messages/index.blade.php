<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">
                <i class="fa fa-envelope me-2 text-primary"></i>Contact Messages
            </h4>
            <input
                type="text"
                class="form-control form-control-sm"
                placeholder="Search name, email, subject..."
                wire:model.debounce.300ms="search"
                style="min-width: 240px;"
            >
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @if($messages->isEmpty())
                    <div class="p-4 text-center text-muted">
                        No contact messages yet.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th style="width: 80px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($messages as $msg)
                                    <tr>
                                        <td>{{ $msg->first_name }} {{ $msg->last_name }}</td>
                                        <td>
                                            <a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a>
                                        </td>
                                        <td>{{ Str::limit($msg->subject ?? '—', 40) }}</td>
                                        <td class="small text-muted">{{ $msg->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#messageModal{{ $msg->id }}"
                                            >
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                    {{-- Modal for full message --}}
                                    <div class="modal fade" id="messageModal{{ $msg->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Message from {{ $msg->first_name }} {{ $msg->last_name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="mb-2"><strong>Email:</strong> <a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a></p>
                                                    @if($msg->phone)
                                                        <p class="mb-2"><strong>Phone:</strong> {{ $msg->phone }}</p>
                                                    @endif
                                                    @if($msg->subject)
                                                        <p class="mb-2"><strong>Subject:</strong> {{ $msg->subject }}</p>
                                                    @endif
                                                    <p class="mb-0"><strong>Message:</strong></p>
                                                    <div class="bg-light p-3 rounded mt-1" style="white-space: pre-wrap;">{{ $msg->message }}</div>
                                                    <p class="small text-muted mt-2 mb-0">Received {{ $msg->created_at->format('F j, Y \a\t g:i A') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-2">
                        {{ $messages->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
