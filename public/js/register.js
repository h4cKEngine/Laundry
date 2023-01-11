$(document).ready(function () {
    $('#signupform').submit(function(event){
        event.preventDefault();
        let email = $("#email").val();
        let password = $("#password").val();
        let idnumber = $("#matricola").val();
        let name = $("#nome").val();
        let surname = $("#cognome").val();
        let nationality = $("#nationalities option:selected").val();
        let _token = $("meta[name='csrf-token']").attr("content");
        console.log(email, password, idnumber, name, surname, nationality)

        $.ajax({
            type: 'POST',
            url: '/auth/register',
            async: true,
            headers: {
                'X-CSRF-TOKEN': _token
            },
            
            data: {
                email: email,
                password: password,
                nome: name,
                cognome: surname,
                matricola: idnumber,
                nazionalita: nationality
            },

            success: function (result) {
                try {
                    document.cookie = "bearer_token=" + result.bearer_token;
                    location.replace('/');
                }catch(e) {
                    console.log("Errore informazioni errate", e)
                }
            },

            error: function (e){
                alert("Email or ID number already found!");
                console.log("Error", e);
            }
        });
    });
});  