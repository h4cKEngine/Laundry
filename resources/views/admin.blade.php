<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/user.css') }}" >
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/admin.css') }}" >
        <title>Admin</title>
    </head>

    <body class="antialiased">
        <div id="backscreen"></div>
        @include("navbar")

        <!-- Modifica Prenotazioni -->
        <h1> <b>Reservations:</b> </h1>
        <div id="reservation">
            <label>User</label>
            <label>Reservation</label>

            <select id="user_reservation">
                <option>Prova</option>
            </select>
            <button type="button" id="moreinfo_reservation">Info Reservation</button>
        </div>

        <div id="edit_reservation">
            <button id="close_edit_reservation">X</button>
            <h2> <b>Edit Reservation:</b> </h2>
            <form id="reservation_admin">
                @csrf
                <label for="user1">User</label>
                <label for="datepicker1">Date</label>
                <label for="timepicker1">Time*</label>
                <label for="washer1">Washer</label>
                <label for="washing_program1">Washing Program</label>
                <label></label>

                <select name="user1" class="selezione" id="user1"></select>    
                <input type="date" name="datepicker1" id="datepicker1" class="datepicker" format="DD/MM/YYYY" required/>
                <input type="time" name="timepicker1" id="timepicker1" class="timepicker" format="hh:mm" required>
                <select name="washer1" class="selezione" id="washer1"></select>
                <select name="washing_program1" class="selezione" id="washing_program1"></select>
            
                <button type="submit" id="reserve_submit">Reserve</button>
            
                <span class="error_message_date" id="error_message_date1"></span>
                <span class="error_message_time" id="error_message_time1"></span>
            </form>
        </div>

        <!-- Stato delle Lavasciuga -->
        <h1> <b>Washers Status:</b> </h1>
        <form id="washers_status">
            @csrf
            <label for="washer">Washer</label>
            <label for="stato">Status</label>
            <label for=""></label>
        
            <select name="washer" class="washer_status"></select>
            <select name="stato" class="washer_status">
                <option value="1" @if (old('stato') == 1) selected @endif>active</option>
                <option value="0" @if (old('stato') == 0) selected @endif>deactivate</option>
            </select>
        
            <button type="submit">Set</button>
        </form>
        @include("info_account")
        <script src="{{ asset('./js/admin.js') }}"></script>
    </body>
</html>
