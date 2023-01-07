<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/index.css') }}" >
        <title>Laundry</title>
    </head>

    <body class="antialiased">
        @include("navbar")
        @auth
            <h1><b>Washing program price list:</b></h1>
            <div id="washing_program_price_list">
                <div id="washing_program_id"></div>
                <div id="washing_program_name"></div>
                <div id="washing_program_price"></div>
                <div id="washing_program_time"></div>
            </div>
        @endauth
        
        <h2><b>Open from Monday to Friday <br> from 8:00 to 13:00 and from 16:00 to 20:00</b></h2>
        <!--
        @for ($i=0; $i<29; $i++)
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum architecto aspernatur consequatur animi nobis ad blanditiis explicabo ipsum ipsa atque optio, obcaecati sit. Beatae a repellat itaque magnam nostrum. Magni.</p>
        @endfor
        -->
        <script src="{{ asset('./js/index.js') }}"></script>
    </body>
</html>
