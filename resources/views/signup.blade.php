<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/access.css') }}" >
        <title>Signup</title>
    </head>

    <body class="antialiased">
        <!-- Form Registrazione -->
        <form class="form" id="signupform">
            @csrf
            <a href="./" id="arrow"><i class="fa-solid fa-arrow-left-long fa-2xl"></i></a>
            <h1>Sign Up</h1>
            <input type="email" id="email" name="email" class="zocial-dribbble" required placeholder="Email" />
            @if($errors->has('email'))
                <span class="error_message">{{ $errors->first('email') }}</span>
            @endif
            <input type="text" name="matricola" id="matricola" minlength="6" maxlength="6" required placeholder="ID number" pattern="[0-9]{6}" class="zocial-dribbble">
            @if($errors->has('matricola'))
                <span class="error_message">{{ $errors->first('matricola') }}</span>
            @endif
            <input type="text" name="nome" id="nome" pattern="[a-zA-Z]+" class="zocial-dribbble"  required placeholder="Name" />
            <input type="text" pattern="[a-zA-Z]+" name="cognome" id="cognome" class="zocial-dribbble" required placeholder="Surname" />
            @include("nationalities_list")
            <input type="password" id="password" name="password" required minlength="8" maxlength="16" pattten="^(?=.[a-z])(?=.[A-Z])(?=.[0-9])(?=.[!@#$%^&*_=+-]).{8,16}$"; placeholder="Password*"/>
            <input type="password" id="confirm_password" name="confirm_password" required minlength="8" maxlength="16" pattten="^(?=.[a-z])(?=.[A-Z])(?=.[0-9])(?=.[!@#$%^&*_=+-]).{8,16}$"; placeholder="Confirm Password*"/>
                <span class="error_message"></span>
            <input type="submit" value="Sign Up"/>
            <a class="redirect" href="/login">Already have an account? Signin here!</a>
        </form>

        <script src="{{ asset('js/access.js') }}"></script>
        <script src="{{ asset('js/register.js') }}"></script>
    </body>
</html>
