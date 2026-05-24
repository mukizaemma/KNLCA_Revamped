<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New School Visit Request</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 640px; margin: 0 auto; padding: 20px; }
        h1 { color: #1A2E4E; font-size: 1.5rem; margin-bottom: 20px; }
        .field { margin-bottom: 10px; }
        .label { font-weight: 600; color: #555; }
        .box { background: #f9f9f9; padding: 14px; border-radius: 8px; border-left: 4px solid #F9A825; margin-top: 10px; }
        .footer { margin-top: 24px; font-size: 0.85rem; color: #888; }
    </style>
</head>
<body>
    <h1>New School Visit Request</h1>
    <p>A visitor has requested to visit {{ config('app.name') }}.</p>

    <div class="field"><span class="label">Visitor name:</span> {{ $visitor_name }}</div>
    <div class="field"><span class="label">Email:</span> <a href="mailto:{{ $visitor_email }}">{{ $visitor_email }}</a></div>
    @if($visitor_phone)
        <div class="field"><span class="label">Phone:</span> {{ $visitor_phone }}</div>
    @endif
    <div class="field"><span class="label">Reason for visit:</span> {{ $reason }}</div>
    <div class="field"><span class="label">Preferred date &amp; time:</span> {{ $visit_datetime }}</div>

    @if($what_to_see)
        <div class="field">
            <span class="label">What they want to see:</span>
            <div class="box">{{ nl2br(e($what_to_see)) }}</div>
        </div>
    @endif

    @if($has_student)
        <div class="field"><span class="label">Student name:</span> {{ $student_name ?: '—' }}</div>
        <div class="field"><span class="label">Student grade:</span> {{ $student_grade ?: '—' }}</div>
    @endif

    <div class="footer">
        <p>This request was submitted from the “Visit the school” form on {{ config('app.name') }}.</p>
    </div>
</body>
</html>

