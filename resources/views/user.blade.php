<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/user.css') }}" >
        <title>User</title>
    </head>

    <body class="antialiased">
            @include("navbar")
            <!-- Prenotazioni Disponibili -->
            <h1> <b>Available Reservations:</b> </h1>
            <form id="reservation_available">
                @csrf
                <label for="datepicker1">Date</label>
                <label for="timepicker1">Time*</label>
                <label for="washer1">Washer</label>
                <label for="washing_program1">Washing Program</label>
                <label></label>
            
                <input type="date" name="datepicker1" class="datepicker" format="DD/MM/YYYY" required/>
                <input type="time" name="timepicker1" id="timepicker" class="timepicker" required>
                <select name="washer1" class="sel_washer" id="washer1"></select>
                <select name="washing_program1" class="sel_washing_program" id="washing_program1"></select>
            
                <input type="submit" id="reserve_submit" value="Reserve">
            
                <span id="error_message_date"></span>
                <span id="error_message_time"></span>
            </form>
            
            <h1> <b>Reservations:</b> </h1>
            <form id="reservation">
                @csrf
                <label for="datepicker2">Date</label>
                <label for="timepicker2">Time</label>
                <label for="washer2">Washer</label>
                <label for="washing_program2">Washing Program</label>
                <label for=""></label>
                <label for=""></label>
            
                <select name="datepicker2" class="datepicker" format="DD/MM/YYYY" required></select>
                <select name="timepicker2" class="timepicker" required></select>
                <select name="washer2" class="sel_washer" id="washer2"></select>
                <select name="washing_program2" class="sel_washing_program" id="washing_program2"></select>
            
                <input type="submit" id="edit_submit" value="Edit">
            </form>

            <h1> <b>Washers Status:</b> </h1>
            <div id="washers_status">
                @csrf
                <div name="w_name" id="w_name"></div>
                <div name="w_status" id="w_status"></div>
            </div>
            
            @include("info_account")
            <script src="{{ asset('./js/user.js') }}"></script>
    </body>
</html>
