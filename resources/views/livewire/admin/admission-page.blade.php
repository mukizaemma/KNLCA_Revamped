@section('title', 'Admissions Page Content')

<div>
    <div class="bg-light rounded p-4">
        <h4 class="mb-4"><i class="fa fa-file-alt me-2 text-primary"></i>Admissions Page Content</h4>
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form wire:submit.prevent="save">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Page intro (top of page)</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Small label</label>
                            <input type="text" class="form-control" wire:model.defer="intro_label" placeholder="Join us">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Main title</label>
                            <input type="text" class="form-control" wire:model.defer="intro_title" placeholder="Admissions for Nursery & Primary">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subtitle</label>
                        <textarea class="form-control summernote" wire:model.defer="intro_subtitle" rows="2"></textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Featured column badge</label>
                        <input type="text" class="form-control" wire:model.defer="featured_badge" placeholder="Most common" style="max-width:200px;">
                    </div>
                </div>
            </div>

            {{-- Admission Process --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Admission Process</h5>
                    <div class="mb-3">
                        <label class="form-label">Section heading</label>
                        <input type="text" class="form-control" wire:model.defer="process_heading" placeholder="Admission Process">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Steps (one per line or use numbers)</label>
                        <textarea class="form-control summernote @error('admission_process') is-invalid @enderror" wire:model.defer="admission_process" rows="6" placeholder="1. Step one&#10;2. Step two&#10;..."></textarea>
                        @error('admission_process')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- First Admission --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">First Admission</h5>
                    <div class="mb-3">
                        <label class="form-label">Section heading</label>
                        <input type="text" class="form-control" wire:model.defer="first_admission_heading" placeholder="First Admission">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Introductory text</label>
                        <textarea class="form-control summernote @error('first_admission_intro') is-invalid @enderror" wire:model.defer="first_admission_intro" rows="3"></textarea>
                        @error('first_admission_intro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Required documents (one per row)</label>
                        @foreach($first_admission_documents as $idx => $doc)
                            <div class="input-group mb-2" wire:key="first-doc-{{ $idx }}">
                                <input type="text" class="form-control" wire:model.defer="first_admission_documents.{{ $idx }}" placeholder="Document item">
                                <button type="button" class="btn btn-outline-danger" wire:click="removeFirstAdmissionDocument({{ $idx }})"><i class="fa fa-times"></i></button>
                            </div>
                        @endforeach
                        <button type="button" class="btn btn-sm btn-outline-primary" wire:click="addFirstAdmissionDocument"><i class="fa fa-plus me-1"></i> Add item</button>
                    </div>
                </div>
            </div>

            {{-- Transfer from another school --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Transfer from another school</h5>
                    <div class="mb-3">
                        <label class="form-label">Section heading</label>
                        <input type="text" class="form-control" wire:model.defer="transfer_heading" placeholder="Transfer from another school">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Introductory text</label>
                        <textarea class="form-control summernote @error('transfer_intro') is-invalid @enderror" wire:model.defer="transfer_intro" rows="3"></textarea>
                        @error('transfer_intro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Required documents (one per row)</label>
                        @foreach($transfer_documents as $idx => $doc)
                            <div class="input-group mb-2" wire:key="transfer-doc-{{ $idx }}">
                                <input type="text" class="form-control" wire:model.defer="transfer_documents.{{ $idx }}" placeholder="Document item">
                                <button type="button" class="btn btn-outline-danger" wire:click="removeTransferDocument({{ $idx }})"><i class="fa fa-times"></i></button>
                            </div>
                        @endforeach
                        <button type="button" class="btn btn-sm btn-outline-primary" wire:click="addTransferDocument"><i class="fa fa-plus me-1"></i> Add item</button>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Bottom call to action</h5>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" wire:model.defer="cta_title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Text</label>
                        <textarea class="form-control summernote" wire:model.defer="cta_text" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Primary button</label>
                            <input type="text" class="form-control" wire:model.defer="cta_primary_btn">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Secondary button</label>
                            <input type="text" class="form-control" wire:model.defer="cta_secondary_btn">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-1"></i> Save admissions content
                </button>
            </div>
        </form>
    </div>
</div>
