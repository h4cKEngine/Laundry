document.getElementById("submitbtn").onclick = (event) => {
    checkPassword(event);
};

function checkPassword(e){
    if (document.getElementById('password').value === document.getElementById('confirm_password').value) {
        document.getElementById('error_message').style.color = 'green';
        document.getElementById('error_message').innerHTML = 'password matching';
    } else {
        e.preventDefault();
        document.getElementById('error_message').style.color = 'red';
        document.getElementById('error_message').innerHTML = 'password are not matching';
    }
}