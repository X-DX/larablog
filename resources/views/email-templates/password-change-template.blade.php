<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007BFF;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            line-height: 1.6;
            color: #333333;
        }
        .content p {
            margin: 0 0 10px;
        }
        .content .credentials {
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #dddddd;
            border-radius: 5px;
            margin: 10px 0;
        }
        .content .credentials p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Password Updated</h1>
        </div>
        <div class="content">
            <p>Dear <strong>{{ $user->name }}</strong>,</p>
            <p>Your password has been successfully updated. Below are your updated login details:</p>
            <div class="credentials">
                <p><strong>Username/Email:</strong> {{ $user->email }} or {{ $user->username }}</p>
                <p><strong>Password:</strong> {{ $new_password }}</p>
            </div>
            <p>If you did not request this change, please contact our support team immediately.</p>
            <p>Best regards,</p>
            <p>The Larablog Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Larablog. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
