<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/access.css') }}" >
        <title>Login</title>
    </head>

    <body class="antialiased">
        <h1>Pagina Login</h1>
        <!-- Form Login -->
        <form class="form" id="loginform" action="./api/auth/login" method="POST">
            <a href="./" id="arrow"><i class="fa-solid fa-arrow-left-long fa-2xl"></i></a>
            <h1>Login</h1>
            <input type="email" id="email" name="email" class="zocial-dribbble" required placeholder="Email" />
            <input type="password" id="password" name=password_login required minlength="8" maxlength="16" pattten="^(?=.[a-z])(?=.[A-Z])(?=.[0-9])(?=.[!@#$%^&*_=+-]).{8,16}$"; placeholder="Password*"/>
            <span id="error_message"></span>
            <input type="submit" id="submitbtn" value="Login"/>
        </form>

        <ul class=passwordmustbe>*The password must contain:<br>
            - at least 8 characters including a number and an upppercase letter
        </ul>
    </body>
</html>
