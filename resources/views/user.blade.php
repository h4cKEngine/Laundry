<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/user.css') }}" >
        <title>User</title>
    </head>

    <body class="antialiased">
            @include("navbar")
            @include("info_reservation")
            <!-- Prenotazioni Disponibili -->
            <h1> <b>Available Reservations:</b> </h1>
            <form id="reservation_available">
                @csrf
                <label for="datepicker1">Date</label>
                <label for="timepicker1">Time*</label>
                <label for="washer1">Washer</label>
                <label for="washing_program1">Washing Program</label>
                <label></label>
            
                <input type="date" name="datepicker1" id="datepicker" class="datepicker" format="DD/MM/YYYY" required/>
                <input type="time" name="timepicker1" id="timepicker" class="timepicker" required>
                <select name="washer1" class="selezione" id="washer1"></select>
                <select name="washing_program1" class="selezione" id="washing_program1"></select>
            
                <input type="submit" id="reserve_submit" value="Reserve">
            
                <span id="error_message_date"></span>
                <span id="error_message_time"></span>
            </form>
            
            <h1> <b>Reservations:</b> </h1>
            <div id="reservation">
                @csrf
               <select name="sel_reservation" id="sel_reservation" class="selezione"></select>
            
               <button id="moreinfo_submit">More Info</button>
            </div>

            <h1> <b>Washers Status:</b> </h1>
            <div id="washers_status">
                @csrf
                <div id="washer_name"></div>
                <div id="washer_status"></div>
            </div>
            
            @include("info_account")
            <script src="{{ asset('./js/user.js') }}"></script>
    </body>
</html>
