<div>
    <x-page-locator title="About us" :header="$header" />
    @php $a = $siteContent['about'] ?? []; @endphp

    <div class="content page-wrap about-page"
         x-data="{
             active: window.location.hash.replace('#','') || 'overview',
             setActive(id) { this.active = id; },
             go(id) {
                 this.active = id;
                 const el = document.getElementById(id);
                 if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                 history.replaceState(null, '', '#' + id);
             }
         }"
         x-init="
             const params = new URLSearchParams(window.location.search);
             const fromQuery = params.get('section');
             const fromHash = window.location.hash.slice(1);
             const target = fromQuery || fromHash;
             if (target) {
                 active = target;
                 $nextTick(() => {
                     const el = document.getElementById(target);
                     if (el) {
                         el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                         history.replaceState(null, '', '#' + target);
                     }
                 });
             }
             const sections = ['overview','mission-vision','core-values','staff','history','our-schools','inquire'];
             const onScroll = () => {
                 let current = 'overview';
                 for (const id of sections) {
                     const el = document.getElementById(id);
                     if (el && el.getBoundingClientRect().top <= 140) current = id;
                 }
                 active = current;
             };
             window.addEventListener('scroll', onScroll, { passive: true });
         ">

        <nav class="about-jump-nav" aria-label="About page sections">
            <button type="button" class="about-jump-nav__link" :class="{ 'is-active': active === 'overview' }" @click="go('overview')">Overview</button>
            <button type="button" class="about-jump-nav__link" :class="{ 'is-active': active === 'mission-vision' }" @click="go('mission-vision')">Mission &amp; vision</button>
            <button type="button" class="about-jump-nav__link" :class="{ 'is-active': active === 'core-values' }" @click="go('core-values')">Core values</button>
            <button type="button" class="about-jump-nav__link" :class="{ 'is-active': active === 'staff' }" @click="go('staff')">Our staff</button>
            <button type="button" class="about-jump-nav__link" :class="{ 'is-active': active === 'history' }" @click="go('history')">History</button>
            <button type="button" class="about-jump-nav__link" :class="{ 'is-active': active === 'our-schools' }" @click="go('our-schools')">Our schools</button>
            <button type="button" class="about-jump-nav__link about-jump-nav__link--accent" :class="{ 'is-active': active === 'inquire' }" @click="go('inquire')">Get in touch</button>
        </nav>

        {{-- Overview --}}
        <section class="about-section about-section--intro" id="overview">
            <x-about-section-header
                :label="$a['overview_label'] ?? 'School overview'"
                :title="optional($settings)->about_heading ?? 'Nurturing young minds through ACE excellence'"
            />
            @if($settings?->about_description)
                <div class="about-description about-description--block">{!! $settings->about_description !!}</div>
            @else
                <p class="page-lead page-lead--center">{{ $a['overview_fallback'] ?? '' }}</p>
            @endif
        </section>

        {{-- Mission & vision --}}
        <section class="about-section about-section--band" id="mission-vision">
            <x-about-section-header :title="$a['mission_vision_title'] ?? 'Our mission & vision'" />
            @if($settings && ($settings->mission || $settings->vision))
                <div class="about-mv-grid">
                    @if($settings->mission)
                        <article class="about-mv-card">
                            <div class="about-mv-card__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                            </div>
                            <h3>Our mission</h3>
                            <div class="about-mv-body">{!! $settings->mission !!}</div>
                        </article>
                    @endif
                    @if($settings->vision)
                        <article class="about-mv-card">
                            <div class="about-mv-card__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </div>
                            <h3>Our vision</h3>
                            <div class="about-mv-body">{!! $settings->vision !!}</div>
                        </article>
                    @endif
                </div>
            @else
                <p class="page-lead page-lead--center">Mission and vision statements can be added in Admin → School Info.</p>
            @endif
        </section>

        {{-- Core values --}}
        <section class="about-section" id="core-values">
            <x-about-section-header :title="$a['core_values_title'] ?? 'Our core values'" />
            @php
                $cv = is_string(optional($settings)->core_values ?? '') ? ($settings->core_values ?? '') : '';
                $hasHtml = strip_tags($cv) !== $cv;
                $items = [];
                if (!$hasHtml && !empty(trim($cv))) {
                    $items = preg_split('/[\n\r,;]+/', $cv, -1, PREG_SPLIT_NO_EMPTY);
                    $items = array_map('trim', array_filter($items));
                }
            @endphp
            @if(!empty($valueCards))
                <div class="values-grid values-grid--about">
                    @foreach($valueCards as $card)
                        <div class="value-card">
                            <div class="value-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="value-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            @if(!empty($card['name']))
                                <h3 class="value-title">{{ $card['name'] }}</h3>
                            @endif
                            @if(!empty($card['description']))
                                <p class="value-desc">{{ strip_tags($card['description']) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @elseif(!$hasHtml && !empty($items))
                <div class="about-core-values-box">
                    <ul class="values-list values-list--centered">
                        @foreach($items as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif(!empty(trim(strip_tags($cv))))
                <div class="about-core-values-box about-rich-text">{!! $cv !!}</div>
            @else
                <p class="page-lead page-lead--center">Add core values in Admin → School Info, or value cards under About settings.</p>
            @endif
        </section>

        {{-- Staff --}}
        <section class="about-section about-section--band" id="staff">
            <x-about-section-header
                :label="$a['staff_label'] ?? 'Our team'"
                :title="$a['staff_title'] ?? 'Our staff'"
                :subtitle="$a['staff_subtitle'] ?? ''"
            />
            @if($staff->isNotEmpty())
                <div class="team-container team-container--about {{ $staff->count() <= 2 ? 'team-container--centered' : '' }}">
                    @foreach($staff as $member)
                        <a href="{{ route('leadership.show', ['member' => $member->id, 'slug' => \Illuminate\Support\Str::slug($member->full_name)]) }}" class="team-container-item" wire:navigate>
                            <div class="img">
                                @if($member->profile_image)
                                    <img src="{{ asset($member->profile_image) }}" alt="{{ $member->full_name }}" loading="lazy">
                                @else
                                    <div class="img-placeholder"></div>
                                @endif
                            </div>
                            <div class="team-container-item-content">
                                <h4 class="name">{{ $member->full_name }}</h4>
                                @if($member->position)
                                    <label class="title">{{ $member->position }}</label>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="page-lead page-lead--center">{{ $a['staff_empty'] ?? 'Staff profiles will appear here once added in Admin → Staff.' }}</p>
            @endif
        </section>

        {{-- History --}}
        <section class="about-section" id="history">
            <x-about-section-header
                :title="$a['history_title'] ?? 'Our history'"
                :subtitle="$a['history_intro'] ?? ''"
            />
            @if(!empty($a['history_body']) && \App\Support\SiteContent::hasRichTextContent($a['history_body']))
                <div class="about-history about-rich-text">{!! $a['history_body'] !!}</div>
            @else
                <p class="page-lead page-lead--center">School history can be edited in Admin → Page Content → About.</p>
            @endif
        </section>

        {{-- Our schools --}}
        <section class="about-section about-section--band" id="our-schools">
            <x-about-section-header
                :label="$a['affiliate_label'] ?? 'New Life family'"
                :title="$a['affiliate_title'] ?? 'Our schools'"
                :subtitle="$a['affiliate_subtitle'] ?? ''"
            />
            @if(!empty($affiliateSchools))
                <div class="affiliate-schools-grid">
                    @foreach($affiliateSchools as $school)
                        <article class="affiliate-school-card">
                            <h3>{{ $school['name'] }}</h3>
                            @if(!empty($school['location']))
                                <p class="affiliate-school-card__meta">{{ $school['location'] }}</p>
                            @endif
                            @if(!empty($school['description']))
                                <p>{{ $school['description'] }}</p>
                            @endif
                            @if(!empty($school['url']))
                                <a href="{{ $school['url'] }}" class="btn-outline" target="_blank" rel="noopener noreferrer">Visit website</a>
                            @endif
                        </article>
                    @endforeach
                </div>
            @else
                <p class="page-lead page-lead--center">{{ $a['affiliate_empty'] ?? 'Add affiliate schools in Admin → School Info when you are ready.' }}</p>
            @endif
        </section>

        {{-- Inquire --}}
        <section class="about-section about-section--inquire" id="inquire">
            <x-about-section-header
                :label="$a['inquire_label'] ?? 'Contact us'"
                :title="$a['inquire_title'] ?? 'Send us a message'"
                :subtitle="$a['inquire_subtitle'] ?? ''"
            />

            @if($inquirySubmitted)
                <div class="alert-success" role="status">Thank you. Your message has been sent and we will respond soon.</div>
            @endif

            <form class="school-form about-inquire-form" autocomplete="off" novalidate>
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

                <p class="submission-channel-help">{{ $siteContent['contact']['submission_help'] ?? 'Choose WhatsApp or Email to submit your message.' }}</p>
                @error('submission_channel')<span class="error error--block">{{ $message }}</span>@enderror
                <div class="submit-channel-buttons">
                    <button type="button" class="btn-submit-channel btn-submit-channel--whatsapp" wire:click="submitInquiry('whatsapp')" wire:loading.attr="disabled" wire:target="submitInquiry">
                        <span wire:loading.remove wire:target="submitInquiry">Send via WhatsApp</span>
                        <span wire:loading wire:target="submitInquiry">Submitting…</span>
                    </button>
                    <button type="button" class="btn-submit-channel btn-submit-channel--email" wire:click="submitInquiry('email')" wire:loading.attr="disabled" wire:target="submitInquiry">
                        <span wire:loading.remove wire:target="submitInquiry">Send via Email</span>
                        <span wire:loading wire:target="submitInquiry">Submitting…</span>
                    </button>
                </div>
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
