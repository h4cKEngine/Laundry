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
        <!---------------------------- Campi Nascosti ---------------------->
        <!-- Lavasciuga -->
        <div id="info_washer">
            <a id="close_info_washer"><i class="fa-solid fa-x" ></i></a>
            <h2 style="text-align: center;">Info Washer</h2>
    
            <form id="washer_status">
                @csrf
                <label>ID</label>
                <label>Brand</label>
                <label>Status</label>
                <label></label>
                
                <span class="user_status" id="washerid"></span>
                <input type="text" id="washername">
                <input type="checkbox" id="check_washer_status">

                <button type="submit">Set</button>
            </form>
        </div>

        <!-- Programma Lavaggio -->
        <div id="info_washing_program">
            <a id="close_info_washing_program"><i class="fa-solid fa-x"></i></a>
            <h2 style="text-align: center;">Info Washing Program</h2>
        
            <form id="washing_program_status">
                @csrf
                <label>ID</label>
                <label>Nome</label>
                <label>Price</label>
                <label>Time</label>
                <label>Status</label>
                <label></label>
                    
                <span class="washing_program_status" id="washingprogramid"></span>
                <input type="text" class="washing_program_status" id="washingprogramname">
                <input type="number" class="washing_program_status" id="washingprogramprice">
                <input type="time" class="washing_program_status" id="washingprogramtime">
                <input type="checkbox" class="washing_program_status" id="check_washing_program_status">
    
                <button type="submit" id="set_washing_program">Set</button>
            </form>

        </div>

        <!-- Utenti -->
         <div id="info_restore">
            <a id="close_info_restore"><i class="fa-solid fa-x" ></i></a>
            <h2><b>Users Trashed</b></h2>

            <form id="restore_form">
                @csrf
                <label>ID</label>
                <span class="user_restore" id="iduser_restore"></span>
                <label>Email</label>
                <span class="user_restore" id="email_restore"></span>
                <label>Role</label>
                <select class="user_restore" id="role_restore">
                    <option data-id=0>User</option>
                    <option data-id=1>Admin</option>
                </select>
                <label>Deleted At</label>
                <span class="user_restore" id="deleted_at"></span>

                <button type="submit" id="restore_user">Restore</button>
            </form>
        </div>

        <div id="restore_user_field">
            <h4>Are you sure to restore this user?</h4>
            <button type="button" id="cancel">Cancel</button>
            <button type="button" id="restore_user_submit">Restore</button>
        </div>

        <div id="info_user">
            <a id="close_info_user"><i class="fa-solid fa-x" ></i></a>
            <h2>Users</h2>
    
            <form id="user_status">
                @csrf
                <label>ID</label>
                <span class="user_status" id="iduser"></span>
                <label>ID number</label>
                <input class="user_status" type="text" id="idnumber">
                <label>Name</label>
                <input class="user_status" type="text" id="name">
                <label>Surname</label>
                <input class="user_status" type="text" id="surname">
                <label>Email</label>
                <input class="user_status" type="text" id="email">
                <label>Nationality</label>
                @include("nationalities_list")
                <label>Role</label>
                <select class="user_status" type="text" id="role">
                    <option data-id=0>User</option>
                    <option data-id=1>Admin</option>
                </select>
                <label>Status</label>
                <span class="user_status" id="check_user_status"></span>

                <button type="button" id="delete_user_submit">Delete</button>
                <button type="submit" id="set_user">Set</button>
                
            </form>
        </div>

        <div id="delete_user_field">
            <h4>Are you sure to delete this user?</h4>
            <button type="button" id="cancel">Cancel</button>
            <button type="button" id="confirm_softdelete_submit">Delete</button>
        </div>

        <!---------------------------- Campi Mostrati ---------------------->
        <!-- Modifica Prenotazioni -->
        <h1> <b>Reservations</b> </h1>
        <div id="reservation">
            <select id="select_user_reservation">
                <option id="nouser" data-id='nouser' style="display: none">-- Select a User --</option>
            </select>
            <select id="select_reservation">
                <option id="noreservation" data-id='noreservation' style="display: none">-- Select a Reservation --</option>
            </select>
            <button type="button" id="moreinfo_reservation">Info</button>
        </div>

        <div id="edit_reservation">
            <a id="close_edit_reservation"><i class="fa-solid fa-x" ></i></a>
            <h2>Edit Reservation</h2>
            <form id="reservation_admin">
                @csrf
                <label for="user1">User</label>
                <span name="user1" class="selezione" id="user1"></span>
                <label for="reservation1">Reservation</label>
                <span name="reservation1" class="selezione" id="reservation1"></span>
                <label for="datepicker1">Date</label>
                <input type="date" name="datepicker1" id="datepicker1" class="datepicker" format="DD/MM/YYYY" required/>
                <label for="timepicker1">Time</label>
                <input type="time" name="timepicker1" id="timepicker1" class="timepicker" format="HH:mm" required>
                <label for="washer1">Washer</label>
                <select name="washer1" class="selezione" id="washer1"></select>
                <label for="washing_program1">Washing Program</label>
                <select name="washing_program1" class="selezione" id="washing_program1"></select>
                
                <button type="button" id="delete_reservation_submit">Delete</button>
                <button type="submit" id="edit_reservation_submit">Edit</button>
            </form>
            
            <span class="error_message_date" id="error_message_date1"></span>
            <span class="error_message_time" id="error_message_time1"></span>  
        </div>

        <div id="delete_field">
            <h4>Are you sure to delete this reservation?</h4>
            <button type="button" id="cancel">Cancel</button>
            <button type="button" id="confirm_delete_submit">Delete</button>
        </div>


        <!-- aggiunta lavasiuga -->
        <div id="add_washer_div">
            <a id="close_add_washer"><i class="fa-solid fa-x" ></i></a>
            <h2> <b>Add Washer</b> </h2>
            <form id="add_washer_form">
                @csrf
                <label>Brand</label>
                <label>Status</label>
                <label></label>

                <input type="text" id="text_washer">
                <input type="checkbox" class="washer_status" id="check_washer_add_status">

                <button type="submit">Done</button>
            </form>
        </div>

        <!-- Gestione Lavasciuga -->
        <h2> <b>Washers</b> </h2>
        <div id="wgrid">
            <select id="wname">
                <option id="nowasher" data-id='nowasher' style="display: none">-- Select a Washer --</option>
            </select>
            <button type="button" id="info_washer_btn">Info</button>
            <button type="button" id="add_washer_button">Add Washer</button>
        </div>

        <!-- aggiunta programma lavaggio -->
        <div id="add_washing_program_div">
            <a id="close_add_washing_program"><i class="fa-solid fa-x" ></i></a>
            <h2> <b>Add Washing Program</b> </h2>
            <form id="add_washing_program_form">
                @csrf
                <label>Name</label>
                <label>Price</label>
                <label>Time</label>
                <label>Status</label>
                <label></label>

                <input type="text" id="text_washing_program_name">
                <input type="text" id="text_washing_program_price">
                <input type="time" id="text_washing_program_time" class="timepicker" format="HH:mm" required>
                <input type="checkbox" class="washer_status" id="check_washer_add_status">

                <button type="submit">Done</button>
            </form>
        </div>

        <!-- Stato degli Programmi Lavaggio -->
        <h2> <b>Washing Programs</b> </h2>
        <div id="wpgrid">
            <select id="wpname">
                <option id="nowashingprogram" data-id='nowashingprogram' style="display: none">-- Select a Washing Program --</option>
            </select>
            <button type="button" id="info_washing_program_btn">Info</button>
            <button type="button" id="add_washing_program_button">Add Washing Program</button>
        </div>

        <!-- Stato degli Utenti -->
        <h2> <b>Users Status</b> </h2>
        <div id="ugrid">
            <select class="user_status" id="uname">
                <option id="nouser" data-id='nouser' style="display: none">-- Select a User --</option>
            </select>
            <button type="button" id="info_user_btn">Info</button>
        </div>

        <!-- Utenti Eliminati -->
        <h2> <b>Basket</b> </h2>
        <div id="usgrid">
            <select class="user_status" id="utrashed">
                <option id="nousertrashed" data-id='nousertrashed' style="display: none">-- Select a User --</option>
            </select>
            <button type="button" id="restore_user_btn">Restore User</button>
        </div>
        
        @include("info_account")
        <script src="{{ asset('js/admin.js') }}"></script>
    </body>
</html>
