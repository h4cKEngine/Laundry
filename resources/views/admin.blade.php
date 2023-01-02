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
                @csrf
                <label for="user">User</label>
                <label for="datepicker1">Date</label>
                <label for="timepicker1">Time*</label>
                <label for="washer1">Washer</label>
                <label for="washing_program1">Washing Program</label>
                <label></label>
                
                <select name="user" class="sel_user"></select>
                <input type="date" name="datepicker1" class="datepicker" format="DD/MM/YYYY" required/>
                <input type="time" name="timepicker1" class="timepicker" required>
                <select name="washer1" class="selezione"></select>
                <select name="washing_program1" class="selezione"></select>
            
                <input type="submit" value="Reserve">
            
                <span id="error_message_date"></span>
                <span id="error_message_time"></span>
            </form>
        
        <h1> <b>Reservations:</b> </h1>
            <form id="reservation">
                @csrf
                <label for="datepicker2">Date</label>
                <label for="timepicker2">Time*</label>
                <label for="washer2">Washer</label>
                <label for="washing_program2">Washing Program</label>
                <label for=""></label>
                <label for=""></label>

                <select name="datepicker2" class="datepicker" format="DD/MM/YYYY" required></select>
                <select name="timepicker2" class="timepicker" required></select>
                <select name="washer2" class="selezione" required></select>
                <select name="washing_program2" class="selezione" required></select>
            
                <input id="submit_edit_reservation" type="submit" value="Edit">
                <button id="delete_reservation">Delete</button>
            </form>
            
        <h1> <b>Washers Status:</b> </h1>
        <form id="washers_status">
            @csrf
            <label for="washer">Washer</label>
            <label for="status">Status</label>
            <label for=""></label>
        
            <select name="washer" class="washer_status"></select>
            <select name="status" class="washer_status">
                <option value="1" @if (old('status') == 1) selected @endif>active</option>
                <option value="0" @if (old('status') == 0) selected @endif>deactivate</option>
            </select>
        
            <input type="submit" value="Set">
        </form>
        @include("info_account")
        <script src="{{ asset('./js/user.js') }}"></script>
        <script src="{{ asset('./js/admin.js') }}"></script>
    </body>
</html>
