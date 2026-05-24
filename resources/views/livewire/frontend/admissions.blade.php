<div>
    <x-page-locator title="Admissions" :header="$header" />
    <div class="content page-wrap">
        <div class="admissions-page">
            <div class="section-header" style="margin-bottom: 32px;">
                <p class="section-heading">{{ $content->intro_label ?? 'Join us' }}</p>
                <h2 class="section-title">{{ $content->intro_title ?? 'Admissions' }}</h2>
                <p class="section-sub section-sub--center">{{ $content->intro_subtitle ?? '' }}</p>
            </div>
            @php
                $processSteps = $content->admission_process
                    ? (strip_tags($content->admission_process) !== $content->admission_process
                        ? $content->admission_process
                        : nl2br(e($content->admission_process)))
                    : '';
                $firstDocs = $content->first_admission_documents ?? [];
                $transferDocs = $content->transfer_documents ?? [];
            @endphp
            <div class="admissions-three-col">
                <div class="admissions-col admissions-col-left admissions-card">
                    <div class="admissions-col-inner">
                        <h2 class="admissions-heading">{{ $content->process_heading }}</h2>
                        <span class="admissions-heading-accent" aria-hidden="true"></span>
                        @if($processSteps)
                            <div class="admissions-process">{!! $processSteps !!}</div>
                        @endif
                    </div>
                </div>
                <div class="admissions-col admissions-col-center">
                    <div class="admissions-orange-box admissions-featured">
                        @if($content->featured_badge)
                            <span class="admissions-badge">{{ $content->featured_badge }}</span>
                        @endif
                        <h2 class="admissions-heading">{{ $content->first_admission_heading }}</h2>
                        <span class="admissions-heading-accent admissions-heading-accent--dark" aria-hidden="true"></span>
                        @if($content->first_admission_intro)
                            <p class="admissions-intro">{!! $content->first_admission_intro !!}</p>
                        @endif
                        @if(count($firstDocs) > 0)
                            <ul class="admissions-docs">
                                @foreach($firstDocs as $item)
                                    @if(trim((string) $item) !== '')
                                        <li><span class="admissions-check" aria-hidden="true"></span>{{ $item }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="admissions-col admissions-col-right admissions-card">
                    <div class="admissions-col-inner">
                        <h2 class="admissions-heading">{{ $content->transfer_heading }}</h2>
                        <span class="admissions-heading-accent" aria-hidden="true"></span>
                        @if($content->transfer_intro)
                            <p class="admissions-intro">{!! $content->transfer_intro !!}</p>
                        @endif
                        @if(count($transferDocs) > 0)
                            <ul class="admissions-docs">
                                @foreach($transferDocs as $item)
                                    @if(trim((string) $item) !== '')
                                        <li><span class="admissions-check" aria-hidden="true"></span>{{ $item }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            <div class="admissions-cta page-cta">
                <h3 class="page-cta__title">{{ $content->cta_title ?? 'Start your application' }}</h3>
                <p class="page-cta__text">{{ $content->cta_text ?? '' }}</p>
                <div class="page-cta__actions">
                    <a href="{{ route('appointment') }}" class="btn-primary" wire:navigate>{{ $content->cta_primary_btn ?? 'Register your child' }}</a>
                    <a href="{{ route('about') }}#inquire" class="btn-outline" wire:navigate>{{ $content->cta_secondary_btn ?? 'Schedule a school visit' }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
