// Acquisisci cookie selezionato tramite nome
function readCookie(name) {
    return (name = new RegExp('(?:^|;\\s*)' + ('' + name).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&') + '=([^;]*)').exec(document.cookie)) && name[1];
}

// Restituisci il BearerToken
function bearerToken(){
    return readCookie('bearer_token');
}