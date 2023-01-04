<div id="info_reservation">
    <div>
        <button id="close_info_reservation">X</button>
        <h2 style="text-align: center;">Info Reservation</h2>
        <form id= "form_edit">
            <label>Date</label>
            <label>Time</label>
            <label>Washer</label>
            <label>WashingProgram</label>
            <div id="info_single_reservation1"></div>
            <div id="info_single_reservation2"></div>
            <select id=washer2> </select>
            <select id=washing_program2> </select>

        <span class="error_message_date" id="error_message_date2"></span>
        <span class="error_message_time" id="error_message_time2"></span>
        </form>
    </div>
    <button id="delete_reservation_submit">Delete</button>
    <button id="edit_reservation_submit">Edit</button>
</div>

<div id="delete_field">
    <h4>Are you sure to delete this reservation?</h4>
    <button id="cancel">Cancel</button>
    <button id="confirm_delete_submit">Delete</button>
</div>