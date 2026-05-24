<h2>New student registration</h2>
<p><strong>Preferred follow-up:</strong> {{ ucfirst($registration->submission_channel ?? 'email') }}</p>
<p><strong>Student:</strong> {{ $registration->student_full_name }}</p>
<p><strong>Level:</strong> {{ $registration->academic_level }}</p>
@if($registration->date_of_birth)
<p><strong>Date of birth:</strong> {{ $registration->date_of_birth->format('j F Y') }}</p>
@endif
<p><strong>Primary contact:</strong> {{ ucfirst($registration->primary_contact) }}</p>
@if($registration->mother_full_name)
<p><strong>Mother:</strong> {{ $registration->mother_full_name }} — {{ $registration->mother_phone }} — {{ $registration->mother_email }}</p>
@endif
@if($registration->father_full_name)
<p><strong>Father:</strong> {{ $registration->father_full_name }} — {{ $registration->father_phone }} — {{ $registration->father_email }}</p>
@endif
@if($registration->guardian_full_name)
<p><strong>Guardian:</strong> {{ $registration->guardian_full_name }} — {{ $registration->guardian_phone }} — {{ $registration->guardian_email }}</p>
@endif
@if($registration->previous_school_name)
<p><strong>Previous school:</strong> {{ $registration->previous_school_name }}</p>
@endif
