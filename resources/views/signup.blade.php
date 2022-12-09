<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/access.css') }}" >
        <title>Signup</title>
        <script type="text/javascript" src="{{ asset('./js/access.js') }}"></script>
    </head>

    <body class="antialiased">
        <h1>Pagina Signup</h1>
        <!-- Form Registrazione -->
        <form class="form" id="signupform" action="./api/auth/register" method="POST">
            <a href="./" id="arrow"><i class="fa-solid fa-arrow-left-long fa-2xl"></i></a>
            <h1>Sign Up</h1>
            <input type="email" name="email" class="zocial-dribbble" required placeholder="Email" />
            @if($errors->has('email'))
                <div class="error">{{ $errors->first('email') }}</div>
            @endif
            <input type="text" name="matricola" minlength="6" maxlength="6" required placeholder="ID number" pattern="[0-9]{6}" class="zocial-dribbble">
            @if($errors->has('matricola'))
                <div class="error">{{ $errors->first('matricola') }}</div>
            @endif
            <input type="text" name="nome" pattern="[a-zA-Z]+" class="zocial-dribbble"  required placeholder="Name" />
            <input type="text" pattern="[a-zA-Z]+" name="cognome" class="zocial-dribbble" required placeholder="Surname" />
            @include("nationalities_list")
            <input type="password" id="password" name="password" required minlength="8" maxlength="16" pattten="^(?=.[a-z])(?=.[A-Z])(?=.[0-9])(?=.[!@#$%^&*_=+-]).{8,16}$"; placeholder="Password*"/>
            <input type="password" id="confirm_password" name="confirm_password" required minlength="8" maxlength="16" pattten="^(?=.[a-z])(?=.[A-Z])(?=.[0-9])(?=.[!@#$%^&*_=+-]).{8,16}$"; placeholder="Confirm Password*"/>
            <span id="error_message"></span>
            <input type="submit" value="Sign Up"/>
            <a class="redirect" href="/login">Already have an account? Signin here!</a>
        </form>
    </body>
</html>
