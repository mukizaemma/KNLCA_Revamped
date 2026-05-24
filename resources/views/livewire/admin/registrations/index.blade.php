<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">
                <i class="fa fa-user-graduate me-2 text-primary"></i>Student Registrations
            </h4>
            <input
                type="text"
                class="form-control form-control-sm"
                placeholder="Search by student name, level, parent name, email or phone..."
                wire:model.live.debounce.300ms="search"
                style="min-width: 280px;"
            >
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @if($registrations->isEmpty())
                    <div class="p-4 text-center text-muted">
                        @if($search)
                            No registrations match your search.
                        @else
                            No student registrations yet.
                        @endif
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Student</th>
                                    <th>Level</th>
                                    <th>Primary contact</th>
                                    <th>Submitted via</th>
                                    <th>Father</th>
                                    <th>Mother</th>
                                    <th>Submitted</th>
                                    <th style="width: 80px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $reg)
                                    <tr>
                                        <td>
                                            <strong>{{ $reg->student_first_name }} {{ $reg->student_last_name }}</strong>
                                            @if($reg->date_of_birth)
                                                <br><span class="small text-muted">DOB: {{ $reg->date_of_birth->format('M j, Y') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $reg->academic_level ?: '—' }}</td>
                                        <td class="text-capitalize">{{ $reg->primary_contact ?: '—' }}</td>
                                        <td class="text-capitalize">{{ $reg->submission_channel ?: '—' }}</td>
                                        <td class="small">
                                            @if($reg->father_full_name || $reg->father_email || $reg->father_phone)
                                                {{ $reg->father_full_name ?: '—' }}<br>
                                                @if($reg->father_email)<a href="mailto:{{ $reg->father_email }}">{{ $reg->father_email }}</a><br>@endif
                                                @if($reg->father_phone){{ $reg->father_phone }}@endif
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="small">
                                            @if($reg->mother_full_name || $reg->mother_email || $reg->mother_phone)
                                                {{ $reg->mother_full_name ?: '—' }}<br>
                                                @if($reg->mother_email)<a href="mailto:{{ $reg->mother_email }}">{{ $reg->mother_email }}</a><br>@endif
                                                @if($reg->mother_phone){{ $reg->mother_phone }}@endif
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="small text-muted">{{ $reg->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#regModal{{ $reg->id }}"
                                            >
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="regModal{{ $reg->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Registration: {{ $reg->student_first_name }} {{ $reg->student_last_name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="text-primary">Student</h6>
                                                            <p class="mb-1"><strong>Name:</strong> {{ $reg->student_first_name }} {{ $reg->student_last_name }}</p>
                                                            <p class="mb-1"><strong>Level:</strong> {{ $reg->academic_level ?: '—' }}</p>
                                                            @if($reg->date_of_birth)
                                                                <p class="mb-1"><strong>Date of birth:</strong> {{ $reg->date_of_birth->format('F j, Y') }}</p>
                                                            @endif
                                                            <p class="mb-0"><strong>Primary contact:</strong> {{ ucfirst($reg->primary_contact ?? '—') }}</p>
                                                    <p class="mb-0"><strong>Submitted via:</strong> {{ ucfirst($reg->submission_channel ?? '—') }}</p>
                                                    @if($reg->previous_school_name)
                                                        <p class="mb-0 mt-2"><strong>Previous school:</strong> {{ $reg->previous_school_name }}</p>
                                                    @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="text-primary">Father</h6>
                                                            <p class="mb-1">{{ $reg->father_full_name ?: '—' }}</p>
                                                            @if($reg->father_email)<p class="mb-1"><a href="mailto:{{ $reg->father_email }}">{{ $reg->father_email }}</a></p>@endif
                                                            @if($reg->father_phone)<p class="mb-0">{{ $reg->father_phone }}</p>@endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="text-primary">Mother</h6>
                                                            <p class="mb-1">{{ $reg->mother_full_name ?: '—' }}</p>
                                                            @if($reg->mother_email)<p class="mb-1"><a href="mailto:{{ $reg->mother_email }}">{{ $reg->mother_email }}</a></p>@endif
                                                            @if($reg->mother_phone)<p class="mb-0">{{ $reg->mother_phone }}</p>@endif
                                                        </div>
                                                    </div>
                                                    <p class="small text-muted mt-3 mb-0">Submitted {{ $reg->created_at->format('F j, Y \a\t g:i A') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-2">
                        {{ $registrations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
