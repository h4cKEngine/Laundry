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
        
        // Chiamate async
        selectionWashingProgram($btoken);
        selectionWasher($btoken);
        viewReservation($btoken);

        // Creazione reservation
        $("#reservation_available").submit(function(event){
            event.preventDefault();
            let userid = $("#user_id").text();

            let orario = $("#datepicker1").val() + " " + $("#timepicker1").val() + ":00";
            let washerid = $("#washer1").val().split(" ");
            let washingprogramid = $("#washing_program1").val().split(" ");
            $.ajax({
                url: `/api/user/${userid}/reservation/`,
                async: true,
                type: 'POST',
                headers: {
                    "Authorization": 'Bearer ' + $btoken,
                    'Accept' : 'application/json'
                },
                
                data: {
                    orario: orario,
                    id_washer: washerid[0],
                    id_washing_program: washingprogramid[0]
                },

                success: function(response){
                    console.log("Reservation Created");
                    location.reload();
                },
                error: function(e){
                    console.log("Error Creation ", e);
                }
            });
        });

        // Mostra info sulla reservation
        $("#moreinfo_submit").click(function(){
            if($("#sel_reservation option:selected").val() == "-- Select a Reservation --"){
                console.log("No Reservation selected");
                alert("No Reservation selected!\nPick one!");
                return;
            }

            $("#info_reservation").show();
            $("#backscreen").show();
            let userid = $("#user_id").text();
            let reservation = $("#sel_reservation").val().split(" ");
            let reservationid = reservation[0];

            $.ajax({
                url: `/api/user/${userid}/reservation/${reservationid}`,
                type: 'GET',
                headers: {
                    "Authorization": 'Bearer ' + $btoken,
                    'Accept' : 'application/json'
                },
                dataType: "json",

                success: function(response){
                    if($("#info_single_reservation1").children().length > 0 || $("#info_single_reservation2").children().length > 0){
                        console.log("Reservation already selected");
                    }else{
                        let res = response["data"].orario.split(" ");
                        let tempo = res[1].split(":");
                        let ore = tempo[0];
                        let minuti = tempo[1];

                        $("#reservationid").text(reservationid);
                        $("#datepicker2").val(res[0]);
                        $("#timepicker2").val(ore + ':' + minuti);
                        $(`#washer2 option[data-id=${response["data"].id_washer}]`).attr("selected", true);
                        $(`#washing_program2 option[data-id=${response["data"].id_washing_program}]`).attr("selected", true);
                    }
                },
                error: function(e){
                    console.log("Error Info Reservation", e);
                }
            });
        });

        // Chiude tabella info reservation
        $("#close_info_reservation").click(function(){
            $("#info_reservation").hide();
            $("#backscreen").hide();
        });

        // Edit reservation
        $("#form_edit").submit(function(event){
            event.preventDefault();
            let userid = $("#user_id").text();
            let reservationid = $("#reservationid").text();

            let orario = $("#datepicker2").val() + " " + $("#timepicker2").val() + ":00";
            let washer = $("#washer2").val().split(" ");
            let washerid = washer[0];
            let washingprogram = $("#washing_program2").val().split(" ");
            let washingprogramid = washingprogram[0];

            $("#info_reservation").hide();
            $("#backscreen").hide();
            $.ajax({
                url: `/api/user/${userid}/reservation/${reservationid}`,
                type: 'PATCH',
                async: true,
                headers: {
                    "Authorization": 'Bearer ' + $btoken,
                    'Accept' : 'application/json'
                },

                data: {
                    orario: orario,
                    id_washer: washerid,
                    id_washing_program: washingprogramid
                },

                success: function(response){
                    try {
                        console.log("Reservation Edited");
                        location.reload();
                    } catch (e) {
                        console.log("Errore informazione errata", e);
                    }
                },

                error: function(e){
                    console.log("Nessuna Prenotazione Disponibile", e);
                }
            });
        });

        // Popup di conferma eliminazione
        // Mostra
        $("#delete_reservation_submit").click(function(){
            $("#delete_field").show();
            $("#backscreen").css("z-index", 4);
        });

        // Chiudi
        $("#cancel").click(function(){
            $("#delete_field").hide();
            $("#backscreen").css("z-index", 2);
        });

        // Elimina reservation
        $("#confirm_delete_submit").click(function(){
            let userid = $("#user_id").text();
            let reservation = $("#sel_reservation").val().split(" ");
            let reservationid = reservation[0];

            $("#delete_field").hide();
            $("#info_reservation").hide();
            $("#backscreen").css("z-index", 2);
            $("#backscreen").hide();
            $.ajax({
                url: `/api/user/${userid}/reservation/${reservationid}`,
                type: 'DELETE',
                headers: {
                    "Authorization": 'Bearer ' + $btoken,
                    'Accept' : 'application/json'
                },
                
                success: function(response){
                    console.log("Reservation deleted.", response);
                    location.reload();
                },
                error: function(e){
                    console.log("Error Deleting", e);
                }
            });
        });

    });
});

// Visualizza reservation dell'user loggato
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

        success: function(response){
            let res = response["data"];
            if(Object.keys(res).length){ // Controlla la lunghezza delle chiavi
                $("#noreservation").hide();
                for(let i in res){
                    let giorno_ora = res[i].orario.split(" ");
                    let oggi = new Date();
                    var reservation_date = new Date(giorno_ora);
                    if( oggi.getTime() >= reservation_date.getTime() ){
                        console.log("Prenotazione scaduta");
                        continue;
                    }
                    
                    $('#sel_reservation').append('<option>' + res[i].id + ' ' + dayFormat(giorno_ora[0]) + " " + giorno_ora[1] + '</option>');
                }
                }else{
                    $("#noreservation").show();
                }
        },

        error: function(){
            console.log("Nessuna Prenotazione Disponibile");
        }
    });
}

// Stampa la lista delle washer
function selectionWasher($btoken){
    $.ajax({
        url: "/api/washer",
        type: 'GET', 
        headers: {
            "Authorization": 'Bearer ' + $btoken,
            'Accept' : 'application/json'
        },
        dataType: "json",

        success: function(response){
            let res = response["lavasciuga"];
            for(let i in res){
                $('#washer_name').append('<div>' + "ID: " + res[i].id  + ' Brand: ' + res[i].marca + '</div>');
                if(res[i].stato){
                    $('#washer1').append('<option>' + res[i].id  + ' ' + res[i].marca + '</option>');
                    $("#washer2").append('<option data-id="'+ res[i].id  +'">' + res[i].id  + ' ' + res[i].marca + '</option>' );
                    $('#washer_status').append('<div>Status: Enabled</div>');
                }else{
                    $('#washer_status').append('<div>Status: Disabled</div>');
                }
           }
        },
        error: function(e){
            console.log("Error", e);
        }
    });
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

        success: function(response){
            let res = response['programma'];           
            for(let i in res){
                if(res[i].stato){
                    $('#washing_program1').append('<option>' + res[i].id  + ' ' + res[i].nome + ' ' + res[i].prezzo + '€' + '</option>');
                    $('#washing_program2').append('<option data-id="'+ res[i].id  +'">' + res[i].id  + ' ' + res[i].nome + ' ' + res[i].prezzo + '€' + '</option>');
                }
            }
        },
        error: function(e){
            console.log("Error", e);
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

// Formatta la data in dd/mm/yyyy
function dayFormat(day){
    let months = [01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12];
    let date = new Date(day);
    let gg = date.getDate();
    let mm = date.getMonth();
    let yyyy = date.getFullYear();

   return gg + "/" + months[mm] + "/" + yyyy;
}

// Controlla se il giorno selezionato è un sabato o una domenica
function noWeekend(datepicker, errordate){
    datepicker.on('input', function(){
        let day = new Date(this.value).getUTCDay();
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
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0');
    let yyyy = today.getFullYear();

    return yyyy + '-' + mm + '-' + dd;
}

// Ottiene la data a n giorni rispetto l'odierna
function addDaysToDate(date, days){
    let day = new Date(date);
    day.setDate(day.getDate() + days);
    let dd = String(day.getDate()).padStart(2, '0');
    let mm = String(day.getMonth() + 1).padStart(2, '0');
    let yyyy = day.getFullYear();

    return yyyy + '-' + mm + '-' + dd;
}
