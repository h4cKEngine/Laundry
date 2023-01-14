<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/index.css') }}" >
        <title>Laundry</title>
    </head>

    <body class="antialiased">
        @include("navbar")
        <h2 id="h2rainbow"><b>Open from Monday to Friday <br> from 8:00 to 13:00 and from 16:00 to 20:00</b></h2>
        
        <img src="img/laundrylogo.png" id="washerimg">

        @auth
            @if (Auth::user()->ruolo == 0 || Auth::user()->ruolo == 1)
            <h1><b>Washing program price list:</b></h1>
                <div id="washing_program_price_list">
                    <div id="washing_program_id"></div>
                    <div id="washing_program_name"></div>
                    <div id="washing_program_price"></div>
                    <div id="washing_program_time"></div>
                </div>
            @endif
        @else
            <h2>Welcome to Laundry Home Page</h2>
        @endauth  
        
        <script src="{{ asset('js/index.js') }}"></script>
    </body>
</html>
