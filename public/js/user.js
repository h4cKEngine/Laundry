$(document).ready(function(){ 
    var today = getToday();
    var day = addDaysToDate(today, 14); //Da un range fino alle 2 settimane successive
    $('#datepicker').attr( 'min', today);
    $('#datepicker').attr( 'max', day);

    selectionWashingProgram();
    viewReservation();
});

// Controlla che il tempo rientri nel range prestabilito
function timeCheck(){
    $('#timepicker').on('input', function(){
        let t = $(this).val();
        let [hour, minute]  = t.split(":");
        hour = parseInt(hour);
        minute = parseInt(minute);

        if(!((hour >= 8 && hour < 13) || (hour >= 16 && hour < 20))){
            $("#timepicker").val('');
            $("#error_message_time").css("display", "inline");
            $("#error_message_time").css("color", "red");
            $("#error_message_time").html('Out of time range:<br>The available time ranges are: 8:00 to 13:00 and 16:00 to 20:00');
        }else{
            $("#error_message_time").css("display", "none");
            $("#error_message_time").html('');
        }
        $("#timepicker").blur();
    })
}

// Controlla se il giorno selezionato è un sabato o una domenica
function noWeekend(){
    $('#datepicker').on('input', function(){
        var day = new Date(this.value).getUTCDay();
        if([6,0].includes(day)){ // Domenica= 0, Sabato= 6
            this.value = '';
            $("#error_message_date").css("display", "inline");
            $("#error_message_date").css("color", "red");
            $("#error_message_date").html('Weekends are not allowed');
        }else{
            $("#error_message_date").css("display", "none");
            $("#error_message_date").html('');
        }
    });
}

// Ottiene la data odierna
function getToday(){
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    return today;
}

// Ottiene la data a n giorni rispetto l'odierna
function addDaysToDate(date, days){
    var day = new Date(date);
    day.setDate(day.getDate() + days);
    var dd = String(day.getDate()).padStart(2, '0');
    var mm = String(day.getMonth() + 1).padStart(2, '0');
    var yyyy = day.getFullYear();

    day = yyyy + '-' + mm + '-' + dd;
    return day;
}

// Visualizza le prenotazioni in generale
function viewReservation(){
    var user = $('#user_id').val();
    $.ajax({
        url: `/api/user/${user}/reservation`,
        type: 'GET',
        dataType: "json",

        success: function(result){
            try {
                

                noWeekend();
                timeCheck();
            } catch (e) {
                console.log("Errore informazione errata", e);
            }
        },

        error: function(){
            console.log("Nessuna Prenotazione Disponibile");
        }
    });
}

// Seleziona il programma lavaggio
function selectionWashingProgram(){
    $('#sel_progr_lav').append('<option value=0>--Pick one--</option>');

    $.ajax({
        url: "/api/washing_program",
        type: 'GET',
        dataType: "json",
        success: function(response){
            for(i in response){
                console.log(response[i]);
                $('#sel_progr_lav').append('<option value=' + response[i]['id'] + '>' + response[i]['nome'] + ' ' + response[i]['durata'] + response[i]['prezzo'] + '</option>');
           }
        },
        error: function(){
            console.log("No View");
        }
    });
}