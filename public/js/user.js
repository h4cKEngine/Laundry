$(document).ready(function(){ 
    var today = getToday();
    var day = addDaysToDate(today, 14); // Imposta un range fino alle 2 settimane successive
    $('#datepicker').attr('min', today);
    $('#datepicker').attr('max', day);
    noWeekend();
    timeCheck();
    
    $.getScript("/js/cookie.js", function() {
        console.log("Script cookie.js loaded.");
        $btoken = readCookie('bearer_token');
        //console.log("Bearer: " + $btoken);
        
        // Avaible Reservations
        selectionWashingProgram($btoken);
        selectionWasherStatus($btoken);
        selectionWasher($btoken);
        
        // Reservations
        viewReservation($btoken);
    });
});

// Visualizza reservation
function viewReservation($btoken){
    var userid = $("#user_id").text();
    $.ajax({
        url: `/api/user/${userid}/reservation`,
        type: 'GET',
        headers: {
            "Authorization": 'Bearer ' + $btoken,
            'Accept' : 'application/json'
        },
        dataType: "json",
        data: $btoken,

        success: function(response){
            try {
                var res = response["data"];
                for(let i in res){
                    $('#sel_reservation').append('<option>' + res[i].id + ' ' + res[i].orario + '</option>');
                }
            } catch (e) {
                console.log("Errore informazione errata", e);
            }
        },

        error: function(){
            console.log("Nessuna Prenotazione Disponibile");
        }
    });
}

// Mostra info sulla reservation
$("#moreinfo_submit").click(function(){  
    $("#info_reservation").show();
    try{
        var userid = $("#user_id").text();
        var reservation = $("#sel_reservation").val().split(" ");
        var reservationid = reservation[0];
    }
    catch(e){
        console.log("Error", e);
    }
    $.ajax({
        url: `/api/user/${userid}/reservation/${reservationid}`,
        type: 'GET',
        headers: {
            "Authorization": 'Bearer ' + $btoken,
            'Accept' : 'application/json'
        },
        dataType: "json",
        data: {
            $btoken
        },

        success: function(response){
            $("#info_single_reservation").append("<th style='text-align: left;'>" + response["data"].id_user + "</th>");
            $("#info_single_reservation").append("<th style='text-align: left;'>" + response["data"].id + "</th>");
            $("#info_single_reservation").append("<th style='text-align: left;'>" + response["data"].id_washer + "</th>");
            $("#info_single_reservation").append("<th style='text-align: left;'>" + response["data"].orario + "</th>");
        },
        error: function(e){
            console.log("Error Info Reservation", e);
        }
    });
});

// Chiude tabella info reservation
$("#close_info_reservation").click(function(){
    $("#info_reservation").hide();
});

// Modifica reservation
$("#edit_reservation_submit").submit(function(){
    try{
        var userid = $("#user_id").text();
        var reservation = $("#sel_reservation").val().split(" ");
        var reservationid = reservation[0];
    }
    catch(e){
        console.log("Error", e);
    }
    $.ajax({
        url: `/api/user/${userid}/reservation/${reservationid}`,
        type: 'PATCH',
        headers: {
            "Authorization": 'Bearer ' + $btoken,
            'Accept' : 'application/json'
        },
        dataType: "json",

        success: function(response){
            try {
                var res = response["data"];
                console.log(res);

                for(let i in res){
                    $('#sel_reservation').append('<option>' + 'ID:' + res[i].id + ' ' + res[i].orario + '</option>');
                }
            } catch (e) {
                console.log("Errore informazione errata", e);
            }
        },

        error: function(){
            console.log("Nessuna Prenotazione Disponibile");
        }
    });
});

// Popup di conferma
// Mostra
$("#delete_reservation_submit").click(function(){
    $("#delete_field").show();
});

// Chiudi
$("#cancel").click(function(){
    $("#delete_field").hide();
});

// Elimina reservation
$("#confirm_delete_submit").click(function(){
    var userid = $("#user_id").text();
    $.ajax({
        url: `/api/user/${userid}/reservation/${reservationid}`,
        type: 'DELETE',
        headers: {
            "Authorization": 'Bearer ' + $btoken,
            'Accept' : 'application/json'
        },
        dataType: "json",
        data: $btoken,
        
        success: function(response){
            console.log("Reservation deleted.");
        },
        error: function(e){
            console.log("Error Deleting", e);
        }
    });
});

// Creazione reservation
$("#reserse_submit").submit(function(e){
    e.preventDefault();
    var form = new FormData(); // Oggetto FormData
    var userid = $("#user_id").text();
    var washerid = $("#washer1").val().split(" ");
    var washingprogramid = $("#washing_program1").val().split(" ");
    form.append('orario', $("#datepicker").val() + " " + $("#timepicker").val() + ":00");
    form.append('id_user', userid);
    form.append('id_washer', washerid[0]);
    form.append('id_washing_program', washingprogramid[0]);
    form.append('_token', $("meta[name='csrf-token']").attr("content"));
    
    $.ajax({
        url: `/api/user/${userid}/reservation/`,
        type: 'POST',
        headers: {
            "Authorization": 'Bearer ' + $btoken,
            'Accept' : 'application/json'
        },
        dataType: "json",
        data: {
            form,
            $btoken
        },

        success: function(response){
            console.log(response);
        },
        error: function(e){
            console.log("Error Creation ", e);
        }
    });
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

// Seleziona il programma lavaggio
function selectionWashingProgram($btoken){
    $.ajax({
        url: "/api/washing_program",
        type: 'GET',
        headers: {
            "Authorization": 'Bearer ' + $btoken,
            'Accept' : 'application/json'
        },
        dataType: "json",
        data: $btoken,

        success: function(response){
            res = response['programma'];           
            for(let i in res){
                $('#washing_program1').append('<option>' + res[i].id  + ' ' + res[i].nome + ' ' + res[i].prezzo + '€' + '</option>');
            }
        },
        error: function(){
            console.log("Error");
        }
    });
}

// Seleziona la washer
function selectionWasher($btoken){
    $.ajax({
        url: "/api/washer",
        type: 'GET', 
        headers: {
            "Authorization": 'Bearer ' + $btoken,
            'Accept' : 'application/json'
        },
        dataType: "json",
        data: $btoken,

        success: function(response){
            var res = response["lavasciuga"];
            for(let i in res){
                if(res[i].stato){
                    $('#washer1').append('<option>' + res[i].id  + ' ' + res[i].marca + ' </option>');
                }
           }
        },
        error: function(){
            console.log("Error");
        }
    });
}

// Stampa la lista delle washer
function selectionWasherStatus($btoken){
    $.ajax({
        url: "/api/washer",
        type: 'GET', 
        headers: {
            "Authorization": 'Bearer ' + $btoken,
            'Accept' : 'application/json'
        },
        dataType: "json",
        data: $btoken,

        success: function(response){
            var res = response["lavasciuga"];
            for(let i in res){
                $('#washer_name').append('<div>' + "ID: " + res[i].id  + ' Brand: ' + res[i].marca + '</div>');
                if(res[i].stato){
                    $('#washer_status').append('<div>Status: Enabled</div>');
                }else{
                    $('#washer_status').append('<div>Status: Disabled</div>');
                }
           }
        },
        error: function(){
            console.log("Error");
        }
    });
}
