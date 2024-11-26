<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .container {
      max-width: 600px;
      margin: 20px auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .header {
      text-align: center;
      padding: 20px 0;
      border-bottom: 1px solid #eaeaea;
    }
    .header h1 {
      font-size: 24px;
      margin: 0;
      color: #333333;
    }
    .content {
      margin: 20px 0;
      text-align: center;
      color: #555555;
      line-height: 1.6;
    }
    .btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      font-size: 16px;
      color: #ffffff;
      background-color: #007bff;
      text-decoration: none;
      border-radius: 5px;
    }
    .btn:hover {
      background-color: #0056b3;
    }
    .footer {
      text-align: center;
      margin-top: 20px;
      font-size: 12px;
      color: #999999;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Reset Your Password</h1>
    </div>

    <div class="content">
      <p>Hello, {{ $user->name }}</p>
      <a href="{{ $actionlink }}" target="_blank" class="btn">Reset Password</a>
      <p>
        This link is valid for 15 Mins.
      </p>

      <p>If you did not request this, you can safely ignore this email.</p>
    </div>

    <div class="footer">
      <p>&copy; {{ date('Y') }} Larablog. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
