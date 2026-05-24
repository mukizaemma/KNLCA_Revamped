<div>
    <x-page-locator title="Get in touch" :header="$header" />
    @php $a = $siteContent['about'] ?? []; @endphp

    <div class="content page-wrap about-page">
        <section class="about-inquire">
            <x-about-section-header
                :label="$a['inquire_label'] ?? 'Contact us'"
                :title="$a['inquire_title'] ?? 'Send us a message'"
                :subtitle="$a['inquire_subtitle'] ?? ''"
            />

            @if($inquirySubmitted)
                <div class="alert-success" role="status">Thank you. Your message has been sent and we will respond soon.</div>
            @endif

            <form wire:submit="submitInquiry" class="school-form about-inquire-form" autocomplete="off" novalidate>
                <div class="form-row">
                    <div class="form-group">
                        <label for="inquiry_first_name">First name <span class="required">*</span></label>
                        <input type="text" id="inquiry_first_name" wire:model="inquiry_first_name" class="form-control" autocomplete="off">
                        @error('inquiry_first_name')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="inquiry_last_name">Last name <span class="required">*</span></label>
                        <input type="text" id="inquiry_last_name" wire:model="inquiry_last_name" class="form-control" autocomplete="off">
                        @error('inquiry_last_name')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="inquiry_email">Email <span class="required">*</span></label>
                        <input type="email" id="inquiry_email" wire:model="inquiry_email" class="form-control" autocomplete="off">
                        @error('inquiry_email')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="inquiry_phone">Phone / WhatsApp <span class="required">*</span></label>
                        <input type="tel" id="inquiry_phone" wire:model="inquiry_phone" class="form-control" autocomplete="off">
                        @error('inquiry_phone')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="inquiry_type">Reason for contact <span class="required">*</span></label>
                    <select id="inquiry_type" wire:model.live="inquiry_type" class="form-control" autocomplete="off">
                        <option value="">Select an option</option>
                        <option value="general">General enquiry</option>
                        <option value="visit_school">Schedule a school visit</option>
                        <option value="admission">Admissions enquiry</option>
                        <option value="partnership">Partnership</option>
                    </select>
                    @error('inquiry_type')<span class="error">{{ $message }}</span>@enderror
                </div>
                @if($inquiry_type === 'visit_school')
                    <div class="form-row">
                        <div class="form-group">
                            <label for="visit_date">Preferred visit date <span class="required">*</span></label>
                            <input type="date" id="visit_date" wire:model="visit_date" class="form-control" min="{{ date('Y-m-d') }}" autocomplete="off">
                            @error('visit_date')<span class="error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="visit_time">Preferred time <span class="required">*</span></label>
                            <input type="time" id="visit_time" wire:model="visit_time" class="form-control" autocomplete="off">
                            @error('visit_time')<span class="error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label for="inquiry_message">Message <span class="required">*</span></label>
                    <textarea id="inquiry_message" wire:model="inquiry_message" class="form-control" rows="5" autocomplete="off" placeholder="Tell us how we can help…"></textarea>
                    @error('inquiry_message')<span class="error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submitInquiry">Send message</span>
                    <span wire:loading wire:target="submitInquiry">Sending…</span>
                </button>
            </form>

            <div class="page-cta about-inquire-cta">
                <h3 class="page-cta__title">{{ $a['enroll_cta_title'] ?? 'Ready to enrol?' }}</h3>
                <p class="page-cta__text">{{ $a['enroll_cta_text'] ?? '' }}</p>
                <div class="page-cta__actions">
                    <a href="{{ route('appointment') }}" class="btn-primary" wire:navigate>{{ $a['enroll_primary_btn'] ?? 'Register your child' }}</a>
                    <a href="{{ route('admissions') }}" class="btn-secondary" wire:navigate>{{ $a['enroll_secondary_btn'] ?? 'Admissions info' }}</a>
                </div>
            </div>
        </section>
    </div>
</div>
