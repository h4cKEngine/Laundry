$(document).ready(function() {
    $('#submitbtn').click(function(event) {
        checkPassword(event);
    })
});

function checkPassword(e){
    if ($("#password").val() != $("#confirm_password").val()) {
        e.preventDefault();
        $('.error_message').css("color", "red");
        $('.error_message').html('Password are not matching<br>The password must contain:<br>at least 8 characters including a number and an upppercase letter!');
    } else {
        $('.error_message').css("color", "green");
        $('.error_message').html('Password matching!');
    }
}