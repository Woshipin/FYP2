{{-- <h1>Reset Password</h1>
<p>Click the link below to reset the password for your account.</p>
<a href="{{ route("reset.password", $token)}}">Reset Password</a> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="background-color: #fff; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; color: #333;">Reset Password</h2>
        <p style="color: #333;">Hi there,</p>
        <p style="color: #333;">Click the link below to reset the password for your account.</p>
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route("reset.password", $token)}}" style="display: inline-block; background-color: #007bff; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;">Reset Password</a>
        </div>
        <p style="color: #333;">If you did not request a password reset, please ignore this email.</p>
        <p style="color: #333;">Regards,<br>Your Company</p>
    </div>

</body>

</html>
