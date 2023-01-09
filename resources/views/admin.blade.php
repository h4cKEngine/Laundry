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

        <div id="info_washer">
            <button id="close_info_washer">X</button>
            <h2 style="text-align: center;">Info Washer</h2>
    
            <form id="washer_status">
                @csrf
                <label>ID</label>
                <label>Brand</label>
                <label>Status</label>
                <label></label>
                
                <span id="washerid"></span>
                <input type="text" id="washername">
                <input type="checkbox" id="check_washer_status">

                <button type="submit" id="set_washer">Set</button>
            </form>
        </div>

        <!-- Modifica Prenotazioni -->
        <h1> <b>Reservations</b> </h1>
        <div id="reservation">
            <label>User</label>
            <label>Reservation</label>
            <label></label>

            <select id="select_user_reservation">
                <option id="nouser" data-id='nouser' style="display: none">-- Select a User --</option>
            </select>
            <select id="select_reservation">
                <option id="noreservation" data-id='noreservation' style="display: none">-- Select a Reservation --</option>
            </select>
            <button type="button" id="moreinfo_reservation">Info</button>
        </div>

        <div id="edit_reservation">
            <button id="close_edit_reservation">X</button>

            <form id="reservation_admin">
                @csrf
                <label for="user1">User</label>
                <label for="reservation1">Reservation</label>
                <label for="datepicker1">Date</label>
                <label for="timepicker1">Time</label>
                <label for="washer1">Washer</label>
                <label for="washing_program1">Washing Program</label>
                <label></label>
                
                <span name="user1" class="selezione" id="user1"></span>
                <span name="reservation1" class="selezione" id="reservation1"></span>
                <input type="date" name="datepicker1" id="datepicker1" class="datepicker" format="DD/MM/YYYY" required/>
                <input type="time" name="timepicker1" id="timepicker1" class="timepicker" format="HH:mm" required>
                <select name="washer1" class="selezione" id="washer1"></select>
                <select name="washing_program1" class="selezione" id="washing_program1"></select>     
                    <span class="error_message_date" id="error_message_date1"></span>
                    <span class="error_message_time" id="error_message_time1"></span>          
                <button type="button" id="delete_reservation_submit">Delete</button>
                <button type="submit" id="edit_reservation_submit">Edit</button>
            </form>    
        </div>

        <div id="delete_field">
            <h4>Are you sure to delete this reservation?</h4>
            <button type="button" id="cancel">Cancel</button>
            <button type="button" id="confirm_delete_submit">Delete</button>
        </div>

        <!-- Stato delle Lavasciuga -->
        <div style="margin: 0 auto">
            <h2> <b>Washers Status</b> </h2>
            <select name="washer" class="washer_status" id="wname"></select>
            <button type="button" id="info_washer_btn">Info</button>
        </div>
        
        @include("info_account")
        <script src="{{ asset('js/admin.js') }}"></script>
    </body>
</html>
