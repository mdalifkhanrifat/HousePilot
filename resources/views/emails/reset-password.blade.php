<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    
    <div style="max-width: 600px; margin: 0 auto; background-color: white; padding: 20px; border-radius: 8px;">
        <div style="text-align: center;">
            <img src="{{ asset('images/logo.png') }}" alt="HousePilot Logo" style="width: 150px; margin-bottom: 20px;">
        </div>

        <h2 style="color: #333;">Reset Your Password.</h2>
        <p>Your OTP is:</p>
        <h3 style="background-color: #eee; padding: 10px; border-radius: 5px; text-align: center;">{{ $otp }}</h3>
        
        <p>Or click the button below to reset using the link:</p>

        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ config('app.frontend_url') . '/reset-password?token=' . $token }}"
               style="background-color: #6366f1; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                Reset Password
            </a>
        </div>

        <p style="font-size: 12px; color: #999;">This OTP will expire in 10 minutes.</p>
    </div>
</body>
</html>
