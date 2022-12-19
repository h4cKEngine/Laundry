$(document).ready(function () {
    $('#loginform').submit(function(event){
        var formData = { // Oggetto formData
            email: $("#email").val(),
            password: $("#password").val(),
            _token: $("meta[name='csrf-token']").attr("content")
        };

        $.ajax({
            type: 'POST',
            url: '/auth/login',
            async: true,

            data: formData,
            //dataType: "json",

            success: function (result) {
                //console.log(result.bearer_token);
                document.cookie = "bearer_token=" + result.bearer_token;
                console.log(document.cookie);
                window.location.replace('/user');
            },

            error: function (){
                console.log("errore");
            }
        });

        event.preventDefault();
    });

});

    