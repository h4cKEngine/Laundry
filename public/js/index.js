$(document).ready(function(){ 


    $.getScript("/js/cookie.js", function() {
        console.log("Script cookie.js loaded.");
        $btoken = readCookie('bearer_token');
        
        selectionWashingProgram($btoken);
    });
});

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
            var res = response["programma"];
            for(let i in res){
                if(res[i].stato){
                    $('#washing_program_id').append('<div>' + "ID: " + res[i].id  + '</div>');
                    $('#washing_program_name').append('<div>' + res[i].nome + '</div>');
                    $('#washing_program_price').append('<div>' + res[i].prezzo  + "€" + '</div>');
                    $('#washing_program_time').append('<div>' + res[i].durata + '</div>');
                }
           }
        },
        error: function(e){
            console.log("Error",e);
        }
    });
}
