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
            try{
                var userid = $("#user_id").text();

                var orario = $("#datepicker1").val() + " " + $("#timepicker1").val() + ":00";
                var washerid = $("#washer1").val().split(" ");
                var washingprogramid = $("#washing_program1").val().split(" ");
            }
            catch(e){
                console.log("Error Form", e);
            }
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

                success: function(response){
                    if($("#info_single_reservation1").children().length > 0 || $("#info_single_reservation2").children().length > 0){
                        console.log("Reservation already selected");
                    }else{
                        res = response["data"].orario.split(" ");
                        tempo = res[1].split(":");
                        ore = tempo[0];
                        minuti = tempo[1];

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
            try{
                var userid = $("#user_id").text();
                var reservationid = $("#reservationid").text();

                var orario = $("#datepicker2").val() + " " + $("#timepicker2").val() + ":00";
                var washerid = $("#washer2").val().split(" ");
                var washingprogramid = $("#washing_program2").val().split(" ");
            }
            catch(e){
                console.log("Error Edit Form", e);
            }

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
                    id_washer: washerid[0],
                    id_washing_program: washingprogramid[0]
                },

                success: function(response){
                    try {
                        console.log("Reservation Edited");
                        location.reload();
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
            try{
                var userid = $("#user_id").text();
                var reservation = $("#sel_reservation").val().split(" ");
                var reservationid = reservation[0];  
            }
            catch(e){
                console.log("Error Deleting Reservation", e);
            }

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
            try {
                var res = response["data"];
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
                        
                        // let months = [01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12];
                        // let date = new Date(giorno_ora[0]);
                        // let gg = date.getDate();
                        // let mm = date.getMonth();
                        // let yyyy = date.getFullYear();
                        // let format_date = gg + "/" + months[mm] + "/" + yyyy;
                        $('#sel_reservation').append('<option>' + res[i].id + ' ' + dayFormat(giorno_ora[0]) + '</option>');
                    }
                }else{
                    $("#noreservation").show();
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
            var res = response["lavasciuga"];
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
            res = response['programma'];           
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
