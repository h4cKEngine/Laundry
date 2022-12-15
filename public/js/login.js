function login() {
    $.ajax({
        url: '/auth/login',
        method: 'POST',

        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
            email: $('#email').val(),
            password: $('#password').val()
        },

        success: function (res) {
            document.cookie = "token=" + res.plainTextToken;
            window.location.replace('/user');
        },

        error: function (res){
            let errors_res = Array;
            let i = 0;
            for(var key in res.responseJSON.errors){
                errors_res[i] = res.responseJSON.errors[key];
                i++;
            }
            error = errors_res[0];
        }
    });
}