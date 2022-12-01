<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/access.css') }}" >
        <title>Signup</title>
    </head>

    <body class="antialiased">
        <h1>Pagina Signup</h1>
        <!-- Form Registrazione -->
        <form class="form" id="signupform" action="./php/signup_backend.php" method="POST">
            <a href="./index.php" id="arrow"><i class="fa-solid fa-arrow-left-long fa-2xl"></i></a>
            <h1>Sign Up</h1>
            <input type="email" name="email" class="zocial-dribbble" required placeholder="Email" />
            <input type="text" name="IDnumber" maxlength="6" required placeholder="ID number" pattern="[0-9]{6}" class="zocial-dribbble">
            <input type="text" name="name" pattern="[a-zA-Z]+" class="zocial-dribbble"  required placeholder="Name" />
            <input type="text" pattern="[a-zA-Z]+" name="surname" class="zocial-dribbble" required placeholder="Surname" />
            @include("nationalities_list")
            <input type="password" id="password" name=password required minlength="8" maxlength="16" pattten="^(?=.[a-z])(?=.[A-Z])(?=.[0-9])(?=.[!@#$%^&*_=+-]).{8,16}$"; placeholder="Password*"/>
            <input type="password" id=confirm_password name=confirm_password required minlength="8" maxlength="16" pattten="^(?=.[a-z])(?=.[A-Z])(?=.[0-9])(?=.[!@#$%^&*_=+-]).{8,16}$"; placeholder="Confirm Password*"/>
            <span id="error_message"></span>
            <input type="submit" id="submitbtn" value="Sign Up"/>
        </form>

        <ul class=passwordmustbe>*The password must contain:<br>
            - at least 8 characters including a number and an upppercase letter
        </ul> 
    </body>
</html>
