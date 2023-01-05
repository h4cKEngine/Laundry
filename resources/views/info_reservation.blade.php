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