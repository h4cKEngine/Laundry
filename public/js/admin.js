$(document).ready(function(){ 
    var today = getToday();
    var day = addDaysToDate(today, 14); // Imposta un range fino alle 2 settimane successive
    
    $('#datepicker1').attr('min', today);
    $('#datepicker2').attr('min', today);
    $('#datepicker1').attr('max', day);
    $('#datepicker2').attr('max', day);
    timeCheck($("#timepicker1"), $("#error_message_time1"));
    timeCheck($("#timepicker2"), $("#error_message_time2"));
    noWeekend($('#datepicker1'), $("#error_message_date1"));
    noWeekend($('#datepicker2'), $("#error_message_date2"));
    
    $.getScript("/js/cookie.js", function() {
        console.log("Script cookie.js loaded.");
        $btoken = readCookie('bearer_token');
        
        // Users
        viewUsers($btoken);
        
        // Reservations
        $("#select_user_reservation").change(function() {
            viewReservationOfUser($btoken);
        });

        // Washers
        viewWashers($btoken);

        // selectionWashingProgram($btoken);
        // selectionWasher($btoken);
        // viewReservation($btoken);

        // Mostra tabella edit reservation
        $("#moreinfo_reservation").click(function(){
            $("#edit_reservation").show();
            //$("#backscreen").show();
            
        });

        // Chiude tabella edit reservation
        // $("#close_edit_reservation").click(function(){
        //     $("#edit_reservation").hide();
        //     //$("#backscreen").hide();
        // });

        // Tabella Edit Reservation
        $("#reservation_admin").submit(function(event){
            event.preventDefault();
            
        });

        // Tabella Washers Status
        $("#washers_status").submit(function(event){
            event.preventDefault();

        });

    });
});

// Visualizza gli utenti
function viewUsers($btoken){
    $.ajax({
        url: `/api/user/`,
        async: false,
        type: 'GET',
        headers: {
            "Authorization": 'Bearer ' + $btoken,
            'Accept' : 'application/json'
        },

        success: function(response){
            let res = response["utenti"];
            for(let i in res){
                $("#select_user_reservation").append(`<option data-id=${res[i].id}>` + res[i].id + " " + res[i].email + "</option>");
            }
        },
        error: function(e){
            console.log("Error Creation ", e);
        }
    });
}

// Visualizza gli le reservation dell'utente selezionato
function viewReservationOfUser($btoken){
    let userid  = $("#select_user_reservation option:selected").attr("data-id");
    $.ajax({
        url: `/api/user/${userid}/reservation`,
        async: true,
        type: 'GET',
        headers: {
            "Authorization": 'Bearer ' + $btoken,
            'Accept' : 'application/json'
        },

        success: function(response){
            let res = response["data"];
            if(res.length){
                $("#select_reservation").empty();
                for(let i in res){
                    $("#select_reservation").append(`<option data-id=${res[i].id}>` + res[i].id + " " + res[i].orario + "</option>");
                }
            }else{
                console.log("No Reservation available");
                $("#select_reservation").empty();
                $("#select_reservation").append("<option style='display: none'>" + "No Reservations Avaiable" + "</option>");
            }
            
        },
        error: function(e){
            console.log("Error Creation ", e);
        }
    });
}

// Visualizza le washer
function viewWashers($btoken){
    $.ajax({
        url: `/api/washer/`,
        async: true,
        type: 'GET',
        headers: {
            "Authorization": 'Bearer ' + $btoken,
            'Accept' : 'application/json'
        },

        success: function(response){
            let res = response["lavasciuga"];
            for(let i in res){
                $("#wname").append(`<option data-id=${res[i].id}>` + res[i].id + " " + res[i].marca + "</option>");
                if (res[i].stato){
                    $("#wstatus option[data-id=active]").attr("selected", true);
                }else{
                    $("#wstatus option[data-id=deactive]").attr("selected", true);
                }
                
            }
        },
        error: function(e){
            console.log("Error Creation ", e);
        }
    });
}

// Controlla che il tempo rientri nel range prestabilito
function timeCheck(timepicker, errortime){
    timepicker.on('input', function(){
        let t = $(this).val();
        let [hour, minute]  = t.split(":");
        hour = parseInt(hour);
        minute = parseInt(minute);

        if(!((hour >= 8 && hour < 13) || (hour >= 16 && hour < 20))){
            timepicker.val('');
            errortime.css("display", "inline");
            errortime.css("color", "red");
            errortime.html('Out of time range:<br>The available time ranges are:<br>8:00 to 13:00 and 16:00 to 20:00');
        }else{
            errortime.css("display", "none");
            errortime.html('');
        }
        timepicker.blur();
    })
}

// Controlla se il giorno selezionato è un sabato o una domenica
function noWeekend(datepicker, errordate){
    datepicker.on('input', function(){
        var day = new Date(this.value).getUTCDay();
        if([6,0].includes(day)){ // Domenica= 0, Sabato= 6
            this.value = '';
            errordate.css("display", "inline");
            errordate.css("color", "red");
            errordate.html('Weekends are not allowed');
        }else{
            errordate.css("display", "none");
            errordate.html('');
        }
        datepicker.blur();
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
