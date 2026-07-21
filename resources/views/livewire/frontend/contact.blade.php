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

            <form class="contact-form school-form">
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
                        <input type="text" id="phone" wire:model="phone" class="form-control" placeholder="Phone / WhatsApp">
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

                <p class="submission-channel-help">{{ $co['submission_help'] ?? 'Choose WhatsApp or Email to submit your message.' }}</p>
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
