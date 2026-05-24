<div>
<x-page-locator title="Feedback" :header="$header" />
<div class="content page-wrap">
    <div class="feedback-page standard-page">
        @if(session('feedback_success'))
            <div class="alert alert-success">{{ session('feedback_success') }}</div>
        @endif
        <div class="section-header">
            @php $fb = $siteContent['feedback'] ?? []; @endphp
            <p class="section-heading">{{ $fb['section_label'] ?? 'Your voice matters' }}</p>
            <h2 class="section-title">{{ $fb['section_title'] ?? 'Share your feedback' }}</h2>
            <p class="section-sub section-sub--center">{{ $fb['section_subtitle'] ?? '' }}</p>
        </div>
        <form wire:submit="submit" class="feedback-form school-form">
            <div class="form-grid">
                <div class="form-group">
                    <label for="full_name">Name</label>
                    <input type="text" id="full_name" wire:model="full_name" class="form-control">
                    @error('full_name')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" wire:model="email" class="form-control">
                    @error('email')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" wire:model="phone" class="form-control">
                    @error('phone')<span class="error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group">
                <label for="message">Message <span class="required">*</span></label>
                <textarea id="message" wire:model="message" class="form-control" rows="5"></textarea>
                @error('message')<span class="error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Rating (optional)</label>
                <select wire:model="rating_out_of_10" class="form-control" style="max-width:120px">
                    <option value="">--</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}/10</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" wire:model="wants_response">
                    I would like a response
                </label>
            </div>
            @if($wants_response)
                <div class="form-group">
                    <label>Preferred contact</label>
                    <select wire:model="preferred_contact_method" class="form-control" style="max-width:200px">
                        <option value="email">Email</option>
                        <option value="phone">Phone</option>
                        <option value="either">Either</option>
                    </select>
                </div>
            @endif
            <button type="submit" class="btn-primary">Submit feedback</button>
        </form>
    </div>
</div>
</div>
