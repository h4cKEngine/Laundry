$(document).ready(function () {
    $('#loginform').submit(function(event){
        event.preventDefault();
        let email = $("#email").val();
        let password = $("#password").val();
        let _token = $("meta[name='csrf-token']").attr("content");

        $.ajax({
            type: 'POST',
            url: '/auth/login',
            async: true,
            headers: {
                'X-CSRF-TOKEN': _token
            },
            data: {
                email: email,
                password: password
            },

            success: function (result) {
                try {
                    document.cookie = "bearer_token=" + result.bearer_token;
                    location.replace('/');
                } catch(e) {
                    console.log("Errore informazioni errate", e)
                }
            },

            error: function (){
                console.log("Non Trovato!");
                alert("Credential Error!");
            }
        });    
    });
});