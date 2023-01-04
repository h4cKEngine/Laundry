$(document).ready(function(){ 
    var today = getToday();
    var day = addDaysToDate(today, 14); // Imposta un range fino alle 2 settimane successive
    $('#datepicker').attr('min', today);
    $('#datepicker').attr('max', day);
    timeCheck($("#timepicker1"));
    timeCheck($("#timepicker2"));
    noWeekend($('#datepicker1'));
    noWeekend($('#datepicker2'));
    
    $.getScript("/js/cookie.js", function() {
        console.log("Script cookie.js loaded.");
        $btoken = readCookie('bearer_token');
        //console.log("Bearer: " + $btoken);
        
        // Avaible Reservations
        selectionWashingProgram($btoken);
        selectionWasher($btoken);
        
        // Reservations
        viewReservation($btoken);
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

                        $("#info_single_reservation1").append('<input type="date" name="datepicker2" id="datepicker2" class="datepicker" format="DD/MM/YYYY" value= ' + res[0] +' required/>');
                        $("#info_single_reservation2").append('<input type="time" name="timepicker2" id="timepicker2" class="timepicker" format="hh:mm" value= ' + ore + ':' + minuti + ' required/>');                  
                        
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

        // Popup di conferma
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
                var reservationid = $("#reservationid").text();
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

        // Creazione reservation
        $("#reservation_available").submit(function(event){
            event.preventDefault();
            var form = new FormData(); // Oggetto FormData
            var userid = $("#user_id").text();
            var washerid = $("#washer1").val().split(" ");
            var washingprogramid = $("#washing_program1").val().split(" ");
            form.append('orario', $("#datepicker").val() + " " + $("#timepicker").val() + ":00");
            form.append('id_user', userid);
            form.append('id_washer', washerid[0]);
            form.append('id_washing_program', washingprogramid[0]);
            form.append('_token', $("meta[name='csrf-token']").attr("content"));
            console.log(form);
            
            $.ajax({
                url: `/api/user/${userid}/reservation/`,
                async: true,
                type: 'POST',
                headers: {
                    "Authorization": 'Bearer ' + $btoken,
                    'Accept' : 'application/json'
                },
                
                data: form,
                contentType: false,
                processData: false,
                cache: false,

                success: function(response){
                    console.log(response);
                    location.reload();
                },
                error: function(e){
                    console.log("Error Creation ", e);
                }
            });
        });

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

        success: function(response){
            try {
                var res = response["data"];
                if(Object.keys(res).length){
                    $("#noreservation").hide();
                    for(let i in res){                    
                        $('#sel_reservation').append('<option>' + res[i].id + ' ' + res[i].orario + '</option>');
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
        error: function(){
            console.log("Error");
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
        error: function(){
            console.log("Error");
        }
    });
}

// Controlla che il tempo rientri nel range prestabilito
function timeCheck(timepicker){
    timepicker.on('input', function(){
        let t = $(this).val();
        let [hour, minute]  = t.split(":");
        hour = parseInt(hour);
        minute = parseInt(minute);

        if(!((hour >= 8 && hour < 13) || (hour >= 16 && hour < 20))){
            timepicker.val('');
            $(".error_message_time").css("display", "inline");
            $(".error_message_time").css("color", "red");
            $(".error_message_time").html('Out of time range:<br>The available time ranges are:<br>8:00 to 13:00 and 16:00 to 20:00');
        }else{
            $(".error_message_time").css("display", "none");
            $(".error_message_time").html('');
        }
        timepicker.blur();
    })
}

// Controlla se il giorno selezionato è un sabato o una domenica
function noWeekend(datepicker){
    datepicker.on('input', function(){
        var day = new Date(this.value).getUTCDay();
        if([6,0].includes(day)){ // Domenica= 0, Sabato= 6
            this.value = '';
            $(".error_message_date").css("display", "inline");
            $(".error_message_date").css("color", "red");
            $(".error_message_date").html('Weekends are not allowed');
        }else{
            $(".error_message_date").css("display", "none");
            $(".error_message_date").html('');
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
