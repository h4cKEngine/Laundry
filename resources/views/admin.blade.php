<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/user.css') }}" >
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/admin.css') }}" >
        <title>Admin</title>
    </head>

    <body class="antialiased">
        @include("navbar")

        <h1> <b>Available Reservations:</b> </h1>
        <form id="progr_lav_available">
            <label for='sel_user'>User</label>
            <label for="datepicker">Date</label>
            <label for="timepicker">Time*</label>
            <label for="sel_washer">Washer</label>
            <label for="sel_progr_lav">Washing Program</label>
            <label></label>
        
            <select name="sel_user" id="sel_user"></select>
            <input type="date" id="datepicker" format="DD/MM/YYYY" required/>
            <input type="time" id="timepicker" required>
            <select name="sel_washer" id="sel_washer"></select>
            <select name="sel_progr_lav" id="sel_progr_lav"></select>
        
            <input type="submit" value="Reserve">
        
            <span id="error_message_date"></span>
            <span id="error_message_time"></span>
        </form>

        <h1> <b>All Reservations:</b> </h1>
        <<div class="grid-container">
            <div class="grid-item">User</div>
            <div class="grid-item">Date</div>
            <div class="grid-item">Time</div>  
            <div class="grid-item">Washer</div>
            <div class="grid-item">Washing Program</div>
    </body>
</html>
