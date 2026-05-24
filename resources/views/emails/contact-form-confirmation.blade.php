<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We Received Your Message</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        h1 { color: #f46f58; font-size: 1.5rem; margin-bottom: 20px; }
        .message-box { background: #f9f9f9; padding: 16px; border-radius: 8px; border-left: 4px solid #f46f58; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 0.85rem; color: #888; }
    </style>
</head>
<body>
    <h1>Thank You for Reaching Out</h1>
    <p>Dear {{ $first_name }},</p>
    <p>We have received your message and will get back to you as soon as possible.</p>

    <p><strong>Here is a copy of your message:</strong></p>
    <div class="message-box">{{ nl2br(e($message)) }}</div>

    <div class="footer">
        <p>Best regards,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
