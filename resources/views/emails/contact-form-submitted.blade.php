<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        h1 { color: #f46f58; font-size: 1.5rem; margin-bottom: 20px; }
        .field { margin-bottom: 12px; }
        .label { font-weight: 600; color: #555; }
        .message-box { background: #f9f9f9; padding: 16px; border-radius: 8px; border-left: 4px solid #f46f58; margin-top: 16px; }
        .footer { margin-top: 24px; font-size: 0.85rem; color: #888; }
    </style>
</head>
<body>
    <h1>New Contact Form Submission</h1>
    <p>A visitor has submitted a message through your contact form.</p>

    <div class="field"><span class="label">Name:</span> {{ $first_name }} {{ $last_name }}</div>
    <div class="field"><span class="label">Email:</span> <a href="mailto:{{ $email }}">{{ $email }}</a></div>
    @if($phone)
    <div class="field"><span class="label">Phone:</span> {{ $phone }}</div>
    @endif
    @if($subject)
    <div class="field"><span class="label">Subject:</span> {{ $subject }}</div>
    @endif
    <div class="field">
        <span class="label">Message:</span>
        <div class="message-box">{{ nl2br(e($message)) }}</div>
    </div>

    <div class="footer">
        <p>This message was sent from the contact form on {{ config('app.name') }}.</p>
    </div>
</body>
</html>
