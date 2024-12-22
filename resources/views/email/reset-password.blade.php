<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-size: 16px;">

    <p>Hello, {{ $mailData['user']->name}}</p>
    <h1>You have requested to change password</h1>
    <h2>please click the link given below to  reset password</h2>

    <a href="{{ route('front.resetPassword', $mailData['token'])}}">Click here</a>
    <p>Thank</p>

</body>
