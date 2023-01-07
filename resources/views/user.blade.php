<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/user.css') }}" >
        <title>User</title>
    </head>

    <body class="antialiased">
            <div id="backscreen"></div>
            @include("navbar")
            
            <div id="info_reservation">
                <button id="close_info_reservation">X</button>
                <h2 style="text-align: center;">Info Reservation</h2>
        
                <form id= "form_edit">
                    <label>ID</label>
                    <label>Date</label>
                    <label>Time</label>
                    <label>Washer</label>
                    <label>WashingProgram</label>
                    <span id="reservationid"></span>
                    <input type="date" name="datepicker2" id="datepicker2" class="datepicker" format="DD/MM/YYYY" required/>
                    <input type="time" name="timepicker2" id="timepicker2" class="timepicker" format="hh:mm" required/>
                    <select id=washer2> </select>
                    <select id=washing_program2> </select>
        
                <span class="error_message_date" id="error_message_date2"></span>
                <span class="error_message_time" id="error_message_time2"></span>
                <button id="delete_reservation_submit">Delete</button>
                <button type="submit" id="edit_reservation_submit">Edit</button>
            </form>
        </div>
        
        <div id="delete_field">
            <h4>Are you sure to delete this reservation?</h4>
            <button id="cancel">Cancel</button>
            <button id="confirm_delete_submit">Delete</button>
        </div>

            <!-- Prenotazioni Disponibili -->
            <h1> <b>Available Reservations:</b> </h1>
            <form id="reservation_available">
                @csrf
                <label for="datepicker1">Date</label>
                <label for="timepicker1">Time*</label>
                <label for="washer1">Washer</label>
                <label for="washing_program1">Washing Program</label>
                <label></label>
            
                <input type="date" name="datepicker1" id="datepicker1" class="datepicker" format="DD/MM/YYYY" required/>
                <input type="time" name="timepicker1" id="timepicker1" class="timepicker" format="hh:mm" required>
                <select name="washer1" class="selezione" id="washer1"></select>
                <select name="washing_program1" class="selezione" id="washing_program1"></select>
            
                <button type="submit" id="reserve_submit">Reserve</button>
            
                <span class="error_message_date" id="error_message_date1"></span>
                <span class="error_message_time" id="error_message_time1"></span>
            </form>
            
            <!-- Prenotazioni dell'utente -->
            <h1> <b>Reservations:</b> </h1>
            <div id="reservation">
               <select name="sel_reservation" id="sel_reservation" class="selezione">
                    <option id="noreservation" data-id='noreservation' style="display: none">-- Select a Reservation --</option>
               </select>
            
               <button id="moreinfo_submit">More Info</button>
            </div>

            <!-- Stato delle Lavasciuga -->
            <h1> <b>Washers Status:</b> </h1>
            <div id="washers_status">
                <div id="washer_name"></div>
                <div id="washer_status"></div>
            </div>
            
            @include("info_account")
            <script src="{{ asset('js/user.js') }}"></script>
    </body>
</html>
