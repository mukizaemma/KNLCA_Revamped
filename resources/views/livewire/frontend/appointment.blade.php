<div>
    @php
        $r = $siteContent['registration'] ?? [];
        $registrationIntro = \App\Support\SiteContent::replacePlaceholders($r['intro'] ?? '', $settings);
        $academicLevels = $r['academic_levels'] ?? ['Nursery', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'];
        $progressPercent = (($step - 1) / (count($steps) - 1)) * 100;
        $academicYear = optional($settings)->registration_academic_year ?? date('Y') . ' – ' . (date('Y') + 1);

        $heroTitle = trim(strip_tags(optional($header)->title ?? '')) ?: 'Student registration';
        $heroSubtitle = null;
        if ($header?->caption && \App\Support\SiteContent::hasRichTextContent($header->caption)) {
            $heroSubtitle = $header->caption;
        } elseif (\App\Support\SiteContent::hasRichTextContent(optional($settings)->registration_message)) {
            $heroSubtitle = $settings->registration_message;
        } elseif (trim(strip_tags($registrationIntro)) !== '') {
            $heroSubtitle = e($registrationIntro);
        }
        $showIntroBelow = trim(strip_tags($registrationIntro)) !== '' && $heroSubtitle !== e($registrationIntro);
    @endphp
    <div class="registration-banner" id="registration-wizard">
        @if($header && $header->image_path)
            <div class="registration-banner__bg" style="background-image: url('{{ asset($header->image_path) }}');"></div>
        @endif
        <div class="registration-banner__overlay"></div>

        <div class="registration-banner__body content">
            <div class="registration-main">
                <header class="registration-hero">
                    <div class="registration-hero__row">
                        <div class="registration-hero__text">
                            <h1 class="registration-hero__title">{{ $heroTitle }}</h1>
                            <span class="registration-hero__accent" aria-hidden="true"></span>
                            @if($heroSubtitle)
                                <div class="registration-hero__message">{!! $heroSubtitle !!}</div>
                            @endif
                        </div>
                        <aside class="registration-hero__year-card" aria-label="Academic year">
                            <span class="registration-hero__year-label">Academic year</span>
                            <span class="registration-hero__year">{{ $academicYear }}</span>
                        </aside>
                    </div>
                </header>

                @if($submitted)
                    <div class="registration-success">
                        <p class="registration-success-title">{{ $r['success_title'] ?? 'Application received' }}</p>
                        <p>{{ $r['success_message'] ?? '' }}</p>
                    </div>
                @else
                    @if($showIntroBelow)
                        <p class="registration-intro">{{ $registrationIntro }}</p>
                    @endif

                    <div class="reg-wizard-progress" aria-label="Registration progress">
                        <div class="reg-wizard-progress__track">
                            <div class="reg-wizard-progress__fill" style="width: {{ $progressPercent }}%;"></div>
                        </div>
                        <ol class="reg-wizard-progress__steps">
                            @foreach($steps as $num => $label)
                                <li class="reg-wizard-progress__step {{ $step === $num ? 'is-current' : '' }} {{ $step > $num ? 'is-complete' : '' }}">
                                    @if($step > $num)
                                        <button type="button" class="reg-wizard-progress__dot" wire:click="goToStep({{ $num }})" aria-label="Go back to step {{ $num }}: {{ $label }}">
                                            <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        </button>
                                    @else
                                        <span class="reg-wizard-progress__dot">{{ $num }}</span>
                                    @endif
                                    <span class="reg-wizard-progress__label">{{ $label }}</span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="registration-form" autocomplete="off" novalidate wire:key="registration-step-{{ $step }}">
                        @if($step === 1)
                            <div class="registration-card">
                                <h2 class="registration-section-title">Student details</h2>
                                <div class="registration-grid registration-grid--2">
                                    <div class="form-group">
                                        <label for="student_first_name">Student first name <span class="required">*</span></label>
                                        <input type="text" id="student_first_name" wire:model.live.debounce.500ms="student_first_name" class="form-control" placeholder="e.g. John" autocomplete="off">
                                        @error('student_first_name')<span class="error">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="student_last_name">Student last name <span class="required">*</span></label>
                                        <input type="text" id="student_last_name" wire:model.live.debounce.500ms="student_last_name" class="form-control" placeholder="e.g. Doe">
                                        @error('student_last_name')<span class="error">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="registration-grid registration-grid--2">
                                    <div class="form-group">
                                        <label for="academic_level">Academic level <span class="required">*</span></label>
                                        <select id="academic_level" wire:model.live="academic_level" class="form-control">
                                            <option value="">Select level</option>
                                            @foreach($academicLevels as $level)
                                                @if(trim((string) $level) !== '')
                                                    <option value="{{ $level }}">{{ $level }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('academic_level')<span class="error">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="date_of_birth">Date of birth</label>
                                        <input type="date" id="date_of_birth" wire:model.live.debounce.500ms="date_of_birth" class="form-control">
                                        @error('date_of_birth')<span class="error">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($step === 2)
                            <div class="registration-card">
                                <h2 class="registration-section-title">Previous school</h2>
                                <div class="form-group">
                                    <label>Is the child coming from another school?</label>
                                    <div class="previous-switch">
                                        <label>
                                            <input type="radio" wire:model.live="from_other_school" value="0">
                                            <span>New to school</span>
                                        </label>
                                        <label>
                                            <input type="radio" wire:model.live="from_other_school" value="1">
                                            <span>From another school</span>
                                        </label>
                                    </div>
                                </div>
                                @if($from_other_school)
                                    <div class="form-group">
                                        <label for="previous_school_name">School name <span class="required">*</span></label>
                                        <input type="text" id="previous_school_name" wire:model.live.debounce.500ms="previous_school_name" class="form-control" placeholder="Previous school name">
                                        @error('previous_school_name')<span class="error">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="previous_school_report">Upload previous academic report (PDF / image)</label>
                                        <input type="file" id="previous_school_report" wire:model="previous_school_report" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        <span wire:loading wire:target="previous_school_report" class="form-hint">Uploading file…</span>
                                        @if($previous_school_report)
                                            <p class="form-hint form-hint--success">File ready: {{ $previous_school_report->getClientOriginalName() }}</p>
                                        @elseif($previous_school_report_filename)
                                            <p class="form-hint">Previously selected: {{ $previous_school_report_filename }}. Please re-upload the file after refreshing the page.</p>
                                        @endif
                                        @error('previous_school_report')<span class="error">{{ $message }}</span>@enderror
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($step === 3)
                            <div class="registration-card">
                                <h2 class="registration-section-title">Parent / guardian contact</h2>
                                <p class="registration-step-help">Enter the details of the person we should contact about this application.</p>

                                <div class="form-group">
                                    <label for="contact_relationship">Relationship to student <span class="required">*</span></label>
                                    <select id="contact_relationship" wire:model.live="contact_relationship" class="form-control">
                                        <option value="mother">Mother</option>
                                        <option value="father">Father</option>
                                        <option value="guardian">Guardian</option>
                                    </select>
                                    @error('contact_relationship')<span class="error">{{ $message }}</span>@enderror
                                </div>

                                <div class="form-group">
                                    <label for="contact_full_name">Full name <span class="required">*</span></label>
                                    <input type="text" id="contact_full_name" wire:model.live.debounce.500ms="contact_full_name" class="form-control" placeholder="Contact person's full name">
                                    @error('contact_full_name')<span class="error">{{ $message }}</span>@enderror
                                </div>

                                <div class="registration-grid registration-grid--2">
                                    <div class="form-group">
                                        <label for="contact_email">Email <span class="required">*</span></label>
                                        <input type="email" id="contact_email" wire:model.live.debounce.500ms="contact_email" class="form-control" placeholder="Email address">
                                        @error('contact_email')<span class="error">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_phone">Phone <span class="required">*</span></label>
                                        <input type="text" id="contact_phone" wire:model.live.debounce.500ms="contact_phone" class="form-control" placeholder="Phone / WhatsApp number">
                                        @error('contact_phone')<span class="error">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($step === 4)
                            <div class="registration-card">
                                <h2 class="registration-section-title">Review your application</h2>
                                <p class="registration-step-help">Please confirm the details below, then choose how you would like to submit.</p>

                                <div class="reg-preview">
                                    <div class="reg-preview__section">
                                        <h3>Student details</h3>
                                        <dl>
                                            <div><dt>Name</dt><dd>{{ $student_first_name }} {{ $student_last_name }}</dd></div>
                                            <div><dt>Academic level</dt><dd>{{ $academic_level }}</dd></div>
                                            @if($date_of_birth)
                                                <div><dt>Date of birth</dt><dd>{{ \Carbon\Carbon::parse($date_of_birth)->format('F j, Y') }}</dd></div>
                                            @endif
                                        </dl>
                                    </div>

                                    <div class="reg-preview__section">
                                        <h3>Previous school</h3>
                                        <dl>
                                            @if($from_other_school)
                                                <div><dt>Previous school</dt><dd>{{ $previous_school_name ?: '—' }}</dd></div>
                                                <div><dt>Academic report</dt><dd>{{ $previous_school_report ? $previous_school_report->getClientOriginalName() : ($previous_school_report_filename ?: 'Not uploaded') }}</dd></div>
                                            @else
                                                <div><dt>Status</dt><dd>New to school</dd></div>
                                            @endif
                                        </dl>
                                    </div>

                                    <div class="reg-preview__section">
                                        <h3>Contact ({{ $this->contactRelationshipLabel() }})</h3>
                                        <dl>
                                            <div><dt>Name</dt><dd>{{ $contact_full_name }}</dd></div>
                                            <div><dt>Email</dt><dd>{{ $contact_email }}</dd></div>
                                            <div><dt>Phone</dt><dd>{{ $contact_phone }}</dd></div>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            <div class="registration-card submission-submit-card">
                                <h2 class="registration-section-title">Submit your registration</h2>
                                <p class="submission-channel-help">{{ $r['submission_help'] ?? 'Choose WhatsApp to open a pre-filled message, or Email to send confirmations to the school and your contact.' }}</p>
                                @error('submission_channel')<span class="error error--block">{{ $message }}</span>@enderror

                                <div class="submit-channel-buttons">
                                    <button type="button" class="btn-submit-channel btn-submit-channel--whatsapp" wire:click="submit('whatsapp')" wire:loading.attr="disabled" wire:target="submit">
                                        <span wire:loading.remove wire:target="submit">
                                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            Send via WhatsApp
                                        </span>
                                        <span wire:loading wire:target="submit">Submitting…</span>
                                    </button>
                                    <button type="button" class="btn-submit-channel btn-submit-channel--email" wire:click="submit('email')" wire:loading.attr="disabled" wire:target="submit">
                                        <span wire:loading.remove wire:target="submit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
                                            Send via Email
                                        </span>
                                        <span wire:loading wire:target="submit">Submitting…</span>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if($step < 4)
                            <div class="registration-wizard-nav">
                                @if($step > 1)
                                    <button type="button" class="btn-wizard btn-wizard--back" wire:click="prevStep">&larr; Back</button>
                                @else
                                    <span></span>
                                @endif
                                <button type="button" class="btn-wizard btn-wizard--next" wire:click="nextStep" wire:loading.attr="disabled" wire:target="nextStep">
                                    <span wire:loading.remove wire:target="nextStep">Next &rarr;</span>
                                    <span wire:loading wire:target="nextStep">Checking…</span>
                                </button>
                            </div>
                        @else
                            <div class="registration-wizard-nav">
                                <button type="button" class="btn-wizard btn-wizard--back" wire:click="prevStep">&larr; Back</button>
                                <span class="registration-wizard-nav__step">Step {{ $step }} of {{ count($steps) }}</span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('registration-step-changed', () => {
            const el = document.getElementById('registration-wizard');
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    </script>
    @endscript

    <style>
    .registration-banner {
        position: relative;
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        min-height: 420px;
        margin-bottom: 40px;
        overflow: hidden;
    }
    .registration-banner__bg {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        filter: brightness(0.8);
        transform: scale(1.03);
    }
    .registration-banner__overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, rgba(26,46,78,0.92), rgba(26,46,78,0.78), rgba(249,168,37,0.35));
    }

    /* Hero + form share one centered column */
    .registration-banner__body {
        position: relative;
        z-index: 2;
        padding: 40px 24px 60px;
    }
    .registration-main {
        max-width: 640px;
        margin: 0 auto;
    }
    .registration-hero {
        margin-bottom: 28px;
        padding-bottom: 24px;
        border-bottom: 1px solid rgba(255,255,255,0.18);
    }
    .registration-hero__row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
    }
    .registration-hero__text {
        flex: 1;
        min-width: 0;
    }
    .registration-hero__title {
        margin: 0;
        font-size: clamp(1.65rem, 3.2vw, 2.15rem);
        font-weight: 700;
        color: #fff;
        line-height: 1.15;
        letter-spacing: -0.02em;
    }
    .registration-hero__accent {
        display: block;
        width: 56px;
        height: 4px;
        margin: 12px 0 14px;
        border-radius: 999px;
        background: var(--primary, #F9A825);
    }
    .registration-hero__message {
        font-size: 0.95rem;
        line-height: 1.65;
        color: rgba(255,255,255,0.88);
        max-width: 420px;
    }
    .registration-hero__message p {
        margin: 0 0 0.45em;
        color: inherit;
    }
    .registration-hero__message p:last-child {
        margin-bottom: 0;
    }
    .registration-hero__year-card {
        flex-shrink: 0;
        align-self: flex-start;
        display: flex;
        flex-direction: column;
        gap: 4px;
        background: var(--navy, #1A2E4E);
        border: 1px solid rgba(255,255,255,0.2);
        border-top: 3px solid var(--primary, #F9A825);
        border-radius: 14px;
        padding: 14px 18px;
        min-width: 160px;
        text-align: center;
        box-shadow: 0 8px 24px rgba(0,0,0,0.28);
    }
    .registration-hero__year-card,
    .registration-hero__year-card * {
        color: #fff !important;
    }
    .registration-hero__year-label {
        display: block;
        margin: 0;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        color: rgba(255,255,255, 0.82) !important;
        font-weight: 600;
    }
    .registration-hero__year {
        display: block;
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #fefce8 !important;
        line-height: 1.2;
    }
    @media (max-width: 640px) {
        .registration-hero__row {
            flex-direction: column;
            align-items: stretch;
        }
        .registration-hero__year-card {
            width: 100%;
            max-width: 280px;
        }
        .registration-hero__message {
            max-width: none;
        }
    }

    .registration-intro {
        color: #e5e7eb;
        margin-bottom: 18px;
        font-size: 0.98rem;
        line-height: 1.7;
    }
    .registration-success {
        text-align: center;
        padding: 32px 24px;
        background: rgba(240,249,240,0.98);
        border-radius: 12px;
        border: 1px solid #c8e6c9;
    }
    .registration-success-title { font-size: 1.25rem; font-weight: 600; color: #2e7d32; margin-bottom: 8px; }
    .registration-success p:last-child { color: #555; margin: 0; }

    .reg-wizard-progress {
        margin-bottom: 24px;
        padding: 18px 20px;
        background: rgba(255,255,255,0.12);
        border-radius: 14px;
        border: 1px solid rgba(255,255,255,0.18);
        backdrop-filter: blur(6px);
    }
    .reg-wizard-progress__track {
        height: 4px;
        background: rgba(255,255,255,0.25);
        border-radius: 999px;
        margin-bottom: 16px;
        overflow: hidden;
    }
    .reg-wizard-progress__fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary, #F9A825), #fcd34d);
        border-radius: 999px;
        transition: width 0.35s ease;
    }
    .reg-wizard-progress__steps {
        list-style: none;
        margin: 0;
        padding: 0;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }
    @media (max-width: 640px) {
        .reg-wizard-progress__steps { grid-template-columns: repeat(2, 1fr); }
        .registration-hero__year-card { width: 100%; max-width: 280px; }
    }
    .reg-wizard-progress__step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        text-align: center;
    }
    .reg-wizard-progress__dot {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        background: rgba(255,255,255,0.2);
        color: rgba(255,255,255,0.7);
        border: 2px solid rgba(255,255,255,0.3);
        transition: all 0.25s ease;
    }
    button.reg-wizard-progress__dot { cursor: pointer; padding: 0; border: 2px solid rgba(255,255,255,0.3); }
    button.reg-wizard-progress__dot svg { width: 16px; height: 16px; }
    .reg-wizard-progress__step.is-current .reg-wizard-progress__dot {
        background: var(--primary, #F9A825);
        color: var(--navy, #1A2E4E);
        border-color: var(--primary, #F9A825);
        box-shadow: 0 0 0 3px rgba(249,168,37,0.35);
    }
    .reg-wizard-progress__step.is-complete .reg-wizard-progress__dot {
        background: #22c55e;
        color: #fff;
        border-color: #22c55e;
    }
    .reg-wizard-progress__label {
        font-size: 0.72rem;
        line-height: 1.3;
        color: rgba(255,255,255,0.75);
        font-weight: 500;
    }
    .reg-wizard-progress__step.is-current .reg-wizard-progress__label { color: #fff; font-weight: 600; }
    .reg-wizard-progress__step.is-complete .reg-wizard-progress__label { color: rgba(255,255,255,0.9); }

    .registration-form .registration-card {
        background: rgba(255,255,255,0.96);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.18);
        padding: 24px;
        margin-bottom: 20px;
        border-top: 4px solid var(--primary, #F9A825);
    }
    .registration-section-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--navy, #1A2E4E);
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--primary, #F9A825);
    }
    .registration-step-help {
        font-size: 0.88rem;
        color: #555;
        line-height: 1.55;
        margin: -8px 0 16px;
    }
    .registration-grid { display: grid; gap: 16px; }
    .registration-grid--2 { grid-template-columns: 1fr 1fr; }
    @media (max-width: 640px) {
        .registration-grid--2 { grid-template-columns: 1fr; }
    }
    .registration-form .form-group { margin-bottom: 16px; }
    .registration-form .form-group:last-child { margin-bottom: 0; }
    .registration-form label { display: block; font-size: 0.9rem; font-weight: 500; margin-bottom: 6px; color: #333; }
    .registration-form .form-control { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.95rem; }
    .registration-form .form-control:focus { outline: none; border-color: var(--primary, #F9A825); box-shadow: 0 0 0 2px rgba(249,168,37,0.2); }
    .registration-form .error { font-size: 0.8rem; color: #c00; margin-top: 4px; display: block; }
    .error--block { margin-bottom: 12px; }
    .registration-form .required { color: #c00; }
    .form-hint { font-size: 0.82rem; color: #666; margin-top: 6px; display: block; }
    .form-hint--success { color: #2e7d32; }

    .registration-wizard-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-top: 8px;
    }
    .registration-wizard-nav__step {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.75);
        font-weight: 500;
    }
    .btn-wizard {
        padding: 12px 28px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        border: none;
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .btn-wizard--back {
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.35);
    }
    .btn-wizard--back:hover { background: rgba(255,255,255,0.25); }
    .btn-wizard--next {
        background: var(--primary, #F9A825);
        color: var(--navy, #1A2E4E);
        box-shadow: 0 4px 14px rgba(249,168,37,0.4);
    }
    .btn-wizard--next:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(249,168,37,0.5); }
    .btn-wizard:disabled { opacity: 0.65; cursor: not-allowed; }

    .reg-preview { display: flex; flex-direction: column; gap: 20px; }
    .reg-preview__section h3 {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--navy, #1A2E4E);
        margin: 0 0 10px;
    }
    .reg-preview__section dl { margin: 0; }
    .reg-preview__section dl > div {
        display: grid;
        grid-template-columns: 130px 1fr;
        gap: 8px;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
        font-size: 0.92rem;
    }
    .reg-preview__section dl > div:last-child { border-bottom: none; }
    .reg-preview__section dt { color: #666; font-weight: 500; margin: 0; }
    .reg-preview__section dd { color: #222; margin: 0; font-weight: 500; }

    .submission-channel-help {
        font-size: 0.88rem;
        color: #555;
        line-height: 1.55;
        margin: 0 0 16px;
    }
    .submit-channel-buttons { display: flex; flex-direction: column; gap: 12px; }
    .btn-submit-channel {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        width: 100%;
        padding: 16px 24px;
        border: none;
        border-radius: 12px;
        font-size: 1.05rem;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
    }
    .btn-submit-channel svg { width: 24px; height: 24px; flex-shrink: 0; }
    .btn-submit-channel--whatsapp { background: #25D366; box-shadow: 0 4px 16px rgba(37,211,102,0.35); }
    .btn-submit-channel--whatsapp:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(37,211,102,0.45); }
    .btn-submit-channel--email { background: #1a1a1a; box-shadow: 0 4px 16px rgba(0,0,0,0.2); }
    .btn-submit-channel--email:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,0,0,0.3); }
    .btn-submit-channel:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }

    .previous-switch {
        display: inline-flex;
        gap: 16px;
        padding: 6px;
        border-radius: 999px;
        background: rgba(255,255,255,0.8);
    }
    .previous-switch label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 0.85rem;
        cursor: pointer;
    }
    .previous-switch input[type="radio"] { accent-color: var(--primary, #F9A825); }
    </style>
</div>
