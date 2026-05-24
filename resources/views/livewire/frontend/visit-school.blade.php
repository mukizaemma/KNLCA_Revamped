<div>
    <x-page-locator title="Visit our school" :header="$header" />
    <div class="content page-wrap">
        <div class="visit-page">
            @if($submitted)
                <div class="visit-success">
                    <p class="visit-success__title">Thank you for your request</p>
                    <p class="visit-success__text">
                        We have received your school visit request. Our team will review it and get back to you with a confirmation.
                    </p>
                </div>
            @else
                <div class="visit-intro-card">
                    <h2 class="visit-intro__heading">We’d love to welcome you to campus</h2>
                    <p class="visit-intro__text">
                        See ACE learning in action—classrooms, play areas, and our caring team. Tell us when you would like to visit and what matters most to your family.
                    </p>
                </div>

                <form wire:submit="submit" class="visit-form school-form">
                    <div class="visit-card">
                        <h3 class="visit-section__title">Your details</h3>
                        <div class="visit-grid visit-grid--2">
                            <div class="form-group">
                                <label for="visitor_name">Full name <span class="required">*</span></label>
                                <input type="text" id="visitor_name" wire:model="visitor_name" class="form-control" placeholder="e.g. Jane Doe">
                                @error('visitor_name')<span class="error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="visitor_email">Email <span class="required">*</span></label>
                                <input type="email" id="visitor_email" wire:model="visitor_email" class="form-control" placeholder="you@example.com">
                                @error('visitor_email')<span class="error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="visit-grid visit-grid--2">
                            <div class="form-group">
                                <label for="visitor_phone">Phone</label>
                                <input type="text" id="visitor_phone" wire:model="visitor_phone" class="form-control" placeholder="+250 7...">
                                @error('visitor_phone')<span class="error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="reason">Reason for visit <span class="required">*</span></label>
                                <select id="reason" wire:model="reason" class="form-control">
                                    <option value="">Select reason</option>
                                    <option value="Touring the school">Touring the school</option>
                                    <option value="Exploring admissions">Exploring admissions</option>
                                    <option value="Meeting a teacher">Meeting a teacher</option>
                                    <option value="Attending an event">Attending an event</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('reason')<span class="error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="visit-card">
                        <h3 class="visit-section__title">When would you like to visit?</h3>
                        <div class="visit-grid visit-grid--3">
                            <div class="form-group">
                                <label for="visit_date">Preferred date <span class="required">*</span></label>
                                <input type="date" id="visit_date" wire:model="visit_date" class="form-control">
                                @error('visit_date')<span class="error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="visit_time">Preferred time <span class="required">*</span></label>
                                <input type="time" id="visit_time" wire:model="visit_time" class="form-control">
                                @error('visit_time')<span class="error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <p class="visit-hint">Visits are typically scheduled during school hours.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="what_to_see">What would you like to see?</label>
                            <textarea id="what_to_see" wire:model="what_to_see" class="form-control" rows="3" placeholder="Classrooms, playground, specific grade, meet leadership team, etc."></textarea>
                            @error('what_to_see')<span class="error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="visit-card">
                        <div class="visit-section-header">
                            <h3 class="visit-section__title">Are you visiting for a student?</h3>
                            <label class="toggle">
                                <input type="checkbox" wire:model="has_student">
                                <span class="toggle-slider"></span>
                                <span class="toggle-label">Yes, I’m visiting for my child</span>
                            </label>
                        </div>

                        @if($has_student)
                            <div class="visit-grid visit-grid--2">
                                <div class="form-group">
                                    <label for="student_name">Student full name</label>
                                    <input type="text" id="student_name" wire:model="student_name" class="form-control" placeholder="Child's full name">
                                    @error('student_name')<span class="error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="student_grade">Current / expected grade</label>
                                    <input type="text" id="student_grade" wire:model="student_grade" class="form-control" placeholder="e.g. Nursery, Grade 2">
                                    @error('student_grade')<span class="error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="visit-actions">
                        <button type="submit" class="visit-submit-btn" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submit">Submit visit request</span>
                            <span wire:loading wire:target="submit">Submitting...</span>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

