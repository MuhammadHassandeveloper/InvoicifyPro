<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ $appName }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            margin: 0 auto;
            max-width: 600px;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            color: #555555;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            font-size: 16px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    @php
     use App\Helpers\AppHelper;
     $appName = AppHelper::site_name();
    @endphp
    <div class="header">
        <h1>Welcome to {{ $appName }}!</h1>
    </div>
    <div class="content">
        <p>Dear {{ $user->first_name }},</p>
        <p>An administrator has created your account on {{ $appName }}. We are excited to have you with us!</p>
        <p>Here are your login credentials:</p>
        <ul>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Password:</strong> {{ $password }}</li>
        </ul>
        <p>Please use the button below to log in to your account and start managing your profile and invoices:</p>
        <a href="{{ url('/login') }}" class="button">Login</a>
        <p>If you have any questions or need assistance, feel free to reply to this email or contact our support team.</p>
        <p>Best regards,</p>
        <p>The Support Team</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
