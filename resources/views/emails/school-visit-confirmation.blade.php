<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your School Visit Request</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 640px; margin: 0 auto; padding: 20px; }
        h1 { color: #1A2E4E; font-size: 1.5rem; margin-bottom: 16px; }
        .badge { display: inline-block; padding: 6px 12px; border-radius: 999px; background: #F9A825; color: #fff; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; }
        .highlight { font-weight: 600; }
        .footer { margin-top: 24px; font-size: 0.85rem; color: #888; }
    </style>
</head>
<body>
    <span class="badge">School visit request</span>
    <h1>Thank you, {{ $visitor_name }}!</h1>
    <p>We have received your request to visit {{ config('app.name') }}.</p>

    <p>
        <span class="highlight">Preferred date &amp; time:</span>
        {{ $visit_datetime }}
    </p>

    <p>Our team will review your request and get back to you shortly to confirm the visit and share any additional details.</p>

    <div class="footer">
        <p>If you did not make this request, please ignore this email.</p>
    </div>
</body>
</html>

