<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Your Contact Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
            color: #777;
        }
        .footer a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reply to Customer Contact Message</h1>
        </div>
        <div class="content">
            <p>Dear {{ $contact->name }},</p>
            <p>Here is the reply to your message:</p>
            <p style="background-color: #f9f9f9; padding: 15px; border-left: 5px solid #007BFF; border-radius: 5px;">
                {{ $replyMessage }}
            </p>
            <p>Best regards,</p>
            <p>Admin</p>
        </div>
        <div class="footer">
            <p>If you have any questions, please <a href="mailto:support@example.com">contact us</a>.</p>
        </div>
    </div>
</body>
</html>
