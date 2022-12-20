$(document).ready(function () {
    $('#signupform').submit(function(event){
        var form = new FormData(); // Oggetto FormData
        form.append('email', $("#email").val());
        form.append('matricola', $("#matricola").val());
        form.append('password', $("#password").val());
        form.append('nome', $("#nome").val());
        form.append('cognome', $("#cognome").val());
        form.append('nazionalita', $("#nazionalita").val());
        form.append('_token', $("meta[name='csrf-token']").attr("content"));

        $.ajax({
            type: 'POST',
            url: '/auth/register',
            async: true,
            
            data: form,
            contentType: false,
            processData: false,
            cache: false,

            success: function (result) {
                document.cookie = "bearer_token=" + result.bearer_token;
                window.location.replace('/');
            },

            error: function (){
                console.log("errore");
            }
        });

        event.preventDefault();
    });

});  