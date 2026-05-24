<div>
<x-page-locator title="Contact us" :header="$header" />
<div class="content page-wrap">
    <div class="contact-page">
        {{-- Contact info header --}}
        @if($settings && ($settings->address || $settings->phone_reception || $settings->phone_urgency || $settings->email))
            <div class="contact-info-header">
                @if($settings->address)
                    <div class="contact-info-item">
                        <span class="contact-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </span>
                        <div>
                            <span class="contact-label">ADDRESS</span>
                            <span class="contact-value">{{ $settings->address }}</span>
                        </div>
                    </div>
                @endif
                @if($settings->phone_reception || $settings->phone_urgency)
                    <div class="contact-info-item">
                        <span class="contact-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </span>
                        <div>
                            <span class="contact-label">PHONE</span>
                            <span class="contact-value">
                                @if($settings->phone_reception)<a href="tel:{{ $settings->phone_reception }}">{{ $settings->phone_reception }}</a>@endif
                                @if($settings->phone_reception && $settings->phone_urgency) · @endif
                                @if($settings->phone_urgency)<a href="tel:{{ $settings->phone_urgency }}">{{ $settings->phone_urgency }}</a>@endif
                            </span>
                        </div>
                    </div>
                @endif
                @if($settings->email)
                    <div class="contact-info-item">
                        <span class="contact-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </span>
                        <div>
                            <span class="contact-label">EMAIL</span>
                            <span class="contact-value"><a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></span>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Get in Touch form --}}
        <div class="contact-form-section school-form">
            @php $co = $siteContent['contact'] ?? []; @endphp
            <p class="section-heading">{{ $co['form_label'] ?? 'Contact' }}</p>
            <h2 class="contact-form-title section-title">{{ $co['form_title'] ?? 'Get in touch' }}</h2>
            <p class="contact-form-sub lead">{{ $co['form_subtitle'] ?? '' }}</p>

            @if(session('contact_success'))
                <div class="alert alert-success">{{ session('contact_success') }}</div>
            @endif

            <form wire:submit="submit" class="contact-form school-form">
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="first_name" wire:model="first_name" class="form-control" placeholder="First Name">
                        @error('first_name')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" id="last_name" wire:model="last_name" class="form-control" placeholder="Last Name">
                        @error('last_name')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="phone" wire:model="phone" class="form-control" placeholder="Phone">
                        @error('phone')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" wire:model="email" class="form-control" placeholder="Email">
                        @error('email')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" id="subject" wire:model="subject" class="form-control" placeholder="Subject">
                    @error('subject')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <textarea id="message" wire:model="message" class="form-control" rows="5" placeholder="Write a message here..."></textarea>
                    @error('message')<span class="error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-send-message btn-primary" wire:loading.attr="disabled" style="width:100%;">
                    <span wire:loading.remove wire:target="submit">Send message</span>
                    <span wire:loading wire:target="submit">Sending...</span>
                </button>
            </form>
        </div>

        {{-- Google Map --}}
        @if($settings && $settings->map_embed_url)
            @php
                $mapUrl = $settings->map_embed_url;
                if (preg_match('/src=["\']([^"\']+)["\']/', $mapUrl, $m)) {
                    $mapUrl = $m[1];
                }
            @endphp
            <div class="contact-map-section">
                <div class="contact-map-wrapper">
                    <iframe
                        src="{{ $mapUrl }}"
                        width="100%"
                        height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Location map"
                    ></iframe>
                </div>
            </div>
        @endif
    </div>
</div>
</div>
