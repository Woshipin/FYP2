<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="background-color: #fff; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; color: #333;">Password Reset Confirmation</h2>
        <p style="color: #333;">Hi there,</p>
        <p style="color: #333;">You have recently requested to reset your password. Please click the button below to confirm your password reset:</p>
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ $verificationLink }}" style="display: inline-block; background-color: #007bff; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;">Confirm Password Reset</a>
        </div>
        <p style="color: #333;">If you did not request a password reset, please ignore this email.</p>
        <p style="color: #333;">Regards,<br>Your Company</p>
    </div>

</body>

</html>
