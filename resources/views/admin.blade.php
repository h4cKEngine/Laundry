<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/user.css') }}" >
        <title>Admin</title>
    </head>

    <body class="antialiased">
        @include("navbar")

        <h1> <b>Available Reservations:</b> </h1>
        
    </body>
</html>
