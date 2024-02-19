<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<style>
    body {
        background-color: #aeaeae;
    }

    .loginMenu {
        width: 360px;
        padding: 8% 0 0;
        margin: auto;
    }

    .form {
        position: relative;
        z-index: 1;
        background: #FFFFFF;
        max-width: 360px;
        margin: 0 auto 100px;
        padding: 45px;
        text-align: center;
        border-radius: 2rem;
        line-height: 33px;
    }

    .form input {
        outline: 0;
        background: #f2f2f2;
        width: 100%;
        border: 0;
        margin: 0 0 15px;
        padding: 15px;
        box-sizing: border-box;
        font-size: 14px;
    }

    .form button {
        text-transform: uppercase;
        outline: 0;
        background: #abff00;
        width: 100%;
        border: 0;
        padding: 15px;
        color: #FFFFFF;
        font-size: 14px;
        -webkit-transition: all 0.3 ease;
        transition: all 0.3 ease;
        cursor: pointer;
        font-weight: bold;
    }

    .form button:hover,
    .form button:active,
    .form button:focus {
        background: #abff01;
        transition: 0.5s;
    }

    .form .message {
        margin: 15px 0 0;
        color: #b3b3b3;
        font-size: 12px;
    }

    .form .message a {
        color: #696969;
        text-decoration: none;
    }

    .form .registerForm {
        display: none;
    }
    #acceptRequestButton{
    border: none;
    color: white;
    padding: 12px 35px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 10px;
    background-color: #abff
    }
</style>

<body>
    <div class="loginMenu">
        <div class="form">
            Subject: Your Exclusive Coupon Code 🎉

            Dear Tutor {{ $student->first_name.' '.$student->last_name }},

            Hi {{ $student->first_name.' '.$student->last_name }},

            Here's your exclusive coupon:

            Coupon Code: <b>{{ $copoun }}</b>

            Grab [Specify Discount Percentage or Amount] off. Use it by [Expiration Date].

            Enjoy learning!

            Cheers,
            {{ Auth::user()->first_name.' '.Auth::user()->last_name }}
        </div>
    </div>
</body>
</html>
