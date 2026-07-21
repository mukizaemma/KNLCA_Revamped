@section('title', 'Page Content')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <h4 class="mb-0"><i class="fa fa-file-alt me-2 text-primary"></i>Page Content</h4>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="resetToDefaults" wire:confirm="Reset all page text to defaults? This does not save until you click Save.">
                    Reset to defaults
                </button>
                <button type="button" class="btn btn-primary btn-sm" wire:click="save">
                    <i class="fa fa-save me-1"></i> Save all
                </button>
            </div>
        </div>
        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <p class="text-muted small">Edit headings, intros, core values, and page headers. Lists (programs, staff, gallery, partners) stay in their own admin menus.</p>

        <ul class="nav nav-pills flex-wrap gap-1 mb-4">
            @foreach(['global' => 'Global', 'home' => 'Home', 'about' => 'About', 'headers' => 'Page Headers', 'facilities' => 'Facilities', 'contact' => 'Contact', 'departments' => 'Academics', 'activities' => 'Activities', 'gallery' => 'Gallery', 'careers' => 'Careers', 'leadership' => 'Staff page', 'feedback' => 'Feedback', 'registration' => 'Register'] as $key => $label)
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $activeTab === $key ? 'active' : '' }}" wire:click="setTab('{{ $key }}')">{{ $label }}</button>
                </li>
            @endforeach
        </ul>

        <form wire:submit.prevent="save">
            @if($activeTab === 'global')
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <div class="mb-3"><label class="form-label">SEO meta description</label>
                        <textarea class="form-control" rows="2" wire:model.defer="sections.global.meta_description"></textarea></div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Top bar tagline</label>
                            <input type="text" class="form-control" wire:model.defer="sections.global.topbar_tagline">
                            <small class="text-muted">Short school line shown in the top bar and sign-in page.</small>
                        </div>
                    </div>
                    <div class="mb-3"><label class="form-label">Footer menu heading</label>
                        <input type="text" class="form-control" wire:model.defer="sections.global.footer_menu_heading" style="max-width:240px;"></div>
                    <div class="mb-0"><label class="form-label">Developer credit (HTML allowed)</label>
                        <input type="text" class="form-control" wire:model.defer="sections.global.developer_credit"></div>
                </div></div>
            @endif

            @if($activeTab === 'home')
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <h6 class="fw-bold">Hero buttons (used when slides have no custom button)</h6>
                    <div class="row">
                        <div class="col-md-3 mb-2"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.hero_primary_text" placeholder="Primary text"></div>
                        <div class="col-md-3 mb-2"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.hero_primary_url" placeholder="/about"></div>
                        <div class="col-md-3 mb-2"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.hero_secondary_text" placeholder="Secondary text"></div>
                        <div class="col-md-3 mb-2"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.hero_secondary_url" placeholder="/appointment"></div>
                    </div>
                </div></div>
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <h6 class="fw-bold">School overview</h6>
                    <div class="row mb-2">
                        <div class="col-md-4"><input type="text" class="form-control" wire:model.defer="sections.home.overview_label" placeholder="Label"></div>
                        <div class="col-md-8"><input type="text" class="form-control" wire:model.defer="sections.home.overview_link_text" placeholder="Link text"></div>
                    </div>
                    <textarea class="form-control summernote" rows="3" wire:model.defer="sections.home.overview_fallback" placeholder="Fallback if home welcome text empty in Settings"></textarea>
                </div></div>
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <h6 class="fw-bold d-flex justify-content-between">Curriculum strip
                        <button type="button" class="btn btn-sm btn-primary" wire:click="addCurriculumPillar">Add pillar</button>
                    </h6>
                    <div class="row mb-2">
                        <div class="col-md-4"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.curriculum_label"></div>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.curriculum_title"></div>
                    </div>
                    <textarea class="form-control summernote mb-2" rows="2" wire:model.defer="sections.home.curriculum_intro"></textarea>
                    <input type="text" class="form-control form-control-sm mb-3" wire:model.defer="sections.home.curriculum_subtitle" placeholder="Curriculum subtitle">
                    @foreach($sections['home']['curriculum_pillars'] ?? [] as $idx => $pillar)
                        <div class="border rounded p-2 mb-2" wire:key="pillar-{{ $idx }}">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Pillar {{ $idx + 1 }}</small>
                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeCurriculumPillar({{ $idx }})"><i class="fa fa-times"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm mb-1" wire:model.defer="sections.home.curriculum_pillars.{{ $idx }}.title">
                            <textarea class="form-control form-control-sm summernote" rows="2" data-summernote-height="160" wire:model.defer="sections.home.curriculum_pillars.{{ $idx }}.description"></textarea>
                        </div>
                    @endforeach
                </div></div>
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <h6 class="fw-bold">Programs</h6>
                    <div class="row g-2 mb-2">
                        <div class="col-md-4"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.programs_label" placeholder="Programs label"></div>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.programs_title"></div>
                        <div class="col-12"><textarea class="form-control form-control-sm summernote" rows="2" data-summernote-height="160" wire:model.defer="sections.home.programs_subtitle"></textarea></div>
                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.programs_link_text"></div>
                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.programs_card_fallback"></div>
                    </div>
                </div></div>
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <h6 class="fw-bold">Core values section</h6>
                    <div class="row g-2">
                        <div class="col-md-4"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.why_choose_label" placeholder="Label"></div>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.why_choose_title" placeholder="Title"></div>
                        <div class="col-12"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.why_choose_empty" placeholder="Empty state hint"></div>
                    </div>
                    <p class="small text-muted mt-2 mb-0">Value cards are edited under the <strong>About</strong> tab (synced to the home values section).</p>
                </div></div>
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <h6 class="fw-bold d-flex justify-content-between">Explore Our School
                        <button type="button" class="btn btn-sm btn-primary" wire:click="addExploreCard">Add card</button>
                    </h6>
                    <div class="row g-2 mb-3">
                        <div class="col-md-4"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.explore_label" placeholder="Label"></div>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.explore_title" placeholder="Title"></div>
                        <div class="col-12"><textarea class="form-control form-control-sm" rows="2" wire:model.defer="sections.home.explore_subtitle" placeholder="Subtitle"></textarea></div>
                        <div class="col-md-6"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.explore_link_text" placeholder="Link text"></div>
                    </div>
                    @foreach($sections['home']['explore_cards'] ?? [] as $idx => $card)
                        <div class="border rounded p-2 mb-2" wire:key="explore-{{ $idx }}">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Card {{ $idx + 1 }}</small>
                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeExploreCard({{ $idx }})"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-4"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.explore_cards.{{ $idx }}.title" placeholder="Title"></div>
                                <div class="col-md-4"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.explore_cards.{{ $idx }}.url" placeholder="/facilities"></div>
                                <div class="col-md-4"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.explore_cards.{{ $idx }}.key" placeholder="Key (optional)"></div>
                                <div class="col-12"><textarea class="form-control form-control-sm" rows="2" wire:model.defer="sections.home.explore_cards.{{ $idx }}.description" placeholder="Description"></textarea></div>
                            </div>
                        </div>
                    @endforeach
                </div></div>
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <h6 class="fw-bold">Gallery / news strip</h6>
                    <div class="row g-2">
                        <div class="col-md-4"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.news_label"></div>
                        <div class="col-md-4"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.news_title"></div>
                        <div class="col-md-4"><input type="text" class="form-control form-control-sm" wire:model.defer="sections.home.news_link_text"></div>
                        <div class="col-12"><textarea class="form-control form-control-sm summernote" rows="2" data-summernote-height="160" wire:model.defer="sections.home.news_empty"></textarea></div>
                    </div>
                </div></div>
            @endif

            @if($activeTab === 'about')
                @foreach(['overview_label','overview_fallback','mission_vision_title','core_values_title','history_title','history_intro','history_body','staff_label','staff_title','staff_subtitle','staff_empty','affiliate_label','affiliate_title','affiliate_subtitle','affiliate_empty','inquire_label','inquire_title','inquire_subtitle','enroll_cta_title','enroll_cta_text','enroll_primary_btn','enroll_secondary_btn'] as $field)
                    <div class="mb-2">
                        <label class="form-label small text-muted">{{ str_replace('_', ' ', ucfirst($field)) }}</label>
                        @if(in_array($field, ['history_body']) || str_contains($field, 'fallback') || str_contains($field, 'subtitle') || str_contains($field, 'empty') || str_contains($field, 'text') || str_contains($field, 'intro') || str_contains($field, 'body'))
                            <textarea class="form-control form-control-sm summernote" rows="2" data-summernote-height="180" wire:model.defer="sections.about.{{ $field }}"></textarea>
                        @else
                            <input type="text" class="form-control form-control-sm" wire:model.defer="sections.about.{{ $field }}">
                        @endif
                    </div>
                @endforeach

                <div class="card border-0 shadow-sm mt-3"><div class="card-body">
                    <h6 class="fw-bold d-flex justify-content-between">Core value cards
                        <button type="button" class="btn btn-sm btn-primary" wire:click="addCoreValueCard">Add card</button>
                    </h6>
                    <p class="small text-muted">Shown on Home (values section) and About. Saving also updates Settings value cards.</p>
                    @foreach($sections['about']['core_value_cards'] ?? [] as $idx => $card)
                        <div class="border rounded p-2 mb-2" wire:key="value-{{ $idx }}">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Value {{ $idx + 1 }}</small>
                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeCoreValueCard({{ $idx }})"><i class="fa fa-times"></i></button>
                            </div>
                            <input type="text" class="form-control form-control-sm mb-1" wire:model.defer="sections.about.core_value_cards.{{ $idx }}.name" placeholder="Name">
                            <textarea class="form-control form-control-sm summernote" rows="2" data-summernote-height="140" wire:model.defer="sections.about.core_value_cards.{{ $idx }}.description" placeholder="Description"></textarea>
                        </div>
                    @endforeach
                </div></div>
            @endif

            @if($activeTab === 'headers')
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <p class="text-muted small">Edit page hero titles and captions. Header background images can still be uploaded in Settings → Page Headers.</p>
                    @foreach($headers as $index => $header)
                        <div class="border rounded p-3 mb-3" wire:key="header-{{ $header['key'] }}">
                            <div class="fw-semibold mb-2">{{ $header['label'] }} <span class="text-muted small">({{ $header['key'] }})</span></div>
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <label class="form-label small text-muted">Title</label>
                                    <input type="text" class="form-control form-control-sm" wire:model.defer="headers.{{ $index }}.title">
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label small text-muted">Caption</label>
                                    <input type="text" class="form-control form-control-sm" wire:model.defer="headers.{{ $index }}.caption">
                                </div>
                            </div>
                            @if(!empty($header['image_path']))
                                <div class="mt-2">
                                    <img src="{{ asset($header['image_path']) }}" alt="" class="img-fluid rounded border" style="max-height: 64px;">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div></div>
            @endif

            @if(in_array($activeTab, ['facilities', 'contact', 'departments', 'activities', 'gallery', 'careers', 'leadership', 'feedback']))
                @php $tab = $sections[$activeTab] ?? []; @endphp
                @foreach($tab as $key => $value)
                    @if(!is_array($value))
                        <div class="mb-2">
                            <label class="form-label small text-muted">{{ str_replace('_', ' ', ucfirst($key)) }}</label>
                            @if($activeTab === 'careers' && $key === 'body')
                                <textarea class="form-control summernote" rows="4" wire:model.defer="sections.{{ $activeTab }}.{{ $key }}"></textarea>
                            @elseif(strlen((string)$value) > 80 || in_array($key, ['section_intro', 'form_subtitle', 'empty', 'cta_text', 'section_subtitle', 'submission_help', 'whatsapp_help', 'email_help']))
                                <textarea class="form-control form-control-sm summernote" rows="2" data-summernote-height="180" wire:model.defer="sections.{{ $activeTab }}.{{ $key }}"></textarea>
                            @else
                                <input type="text" class="form-control form-control-sm" wire:model.defer="sections.{{ $activeTab }}.{{ $key }}">
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif

            @if($activeTab === 'registration')
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <div class="mb-3"><label class="form-label">Form intro</label>
                        <textarea class="form-control summernote" rows="2" wire:model.defer="sections.registration.intro"></textarea>
                        <small class="text-muted">Use <code>{school_name}</code> for school name.</small></div>
                    <div class="mb-3"><label class="form-label">Academic levels</label>
                        @foreach($sections['registration']['academic_levels'] ?? [] as $idx => $level)
                            <div class="input-group input-group-sm mb-1" wire:key="level-{{ $idx }}">
                                <input type="text" class="form-control" wire:model.defer="sections.registration.academic_levels.{{ $idx }}">
                                <button type="button" class="btn btn-outline-danger" wire:click="removeAcademicLevel({{ $idx }})"><i class="fa fa-times"></i></button>
                            </div>
                        @endforeach
                        <button type="button" class="btn btn-sm btn-outline-primary mt-1" wire:click="addAcademicLevel">Add level</button>
                    </div>
                    @foreach(['success_title','success_message','fallback_sidebar','submission_help','whatsapp_help','email_help'] as $field)
                        <div class="mb-2">
                            <label class="form-label small">{{ str_replace('_', ' ', ucfirst($field)) }}</label>
                            <textarea class="form-control form-control-sm summernote" rows="2" data-summernote-height="160" wire:model.defer="sections.registration.{{ $field }}"></textarea>
                        </div>
                    @endforeach
                </div></div>
            @endif

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Save all page content</button>
            </div>
        </form>
    </div>
</div>
