$(document).ready(function () {
    $('#loginform').submit(function(event){
        var form = new FormData(); // Oggetto FormData
        form.append('email', $("#email").val());
        form.append('password', $("#password").val());
        form.append('_token', $("meta[name='csrf-token']").attr("content"));

        $.ajax({
            type: 'POST',
            url: '/auth/login',
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
                alert("Not found!");
            }
        });

        event.preventDefault();
    });

});