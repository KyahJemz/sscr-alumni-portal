<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }
        .header {
            text-align: center;
            padding: 10px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .logo {
            max-width: 100px;
            height: auto;
        }
        h1 {
            color: #333;
        }
        p {
            line-height: 1.6;
            color: #555;
        }
        .credentials {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .disclaimer {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .container {
                padding: 15px;
            }
            h1 {
                font-size: 24px;
            }
            p, .credentials {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="logo">
            <h1>Welcome to the SSCR Alumni Portal</h1>
        </div>

        <p>Dear {{ $data['name'] }},</p>

        <p>We are pleased to inform you that your alumni account has been successfully approved. You can now log in to your account using your Alumni ID and the password.</p>

        <p>The account creation was facilitated by your Program Head and has been approved by the Alumni Coordinator.</p>

        <p>If you have any questions or require further assistance, please feel free to reach out to us.</p>

        <div class="credentials">
            <strong>Your Login Credentials:</strong><br><br>
            <strong>Alumni ID:</strong> {{ $data['alumni_id'] }}<br>
            <strong>Password:</strong> Your password is generated as follows:<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Take the first 2 letters of your first name<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Add the last 2 letters of your last name<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Finally, append your batch year<br><br>
            <strong>Example:</strong> For Juan Dela Cruz, the password would be <strong>JUUZ2024</strong>
        </div>

        <p><strong>We advise you to change your password as soon as you log in for the first time to ensure the security of your account.</strong></p>

        <p>You can log in using the following link: <a href="{{ url('/') }}">Login to SSCR Alumni Portal</a></p>

        <p>Best regards,<br>
        Alumni Relations Team<br>
        SSCR Alumni Portal</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} SSCR Alumni Portal. All rights reserved.</p>
        </div>

        <div class="disclaimer">
            <p><em>This is an automated message. Please do not reply.</em></p>
        </div>
    </div>
</body>
</html>
