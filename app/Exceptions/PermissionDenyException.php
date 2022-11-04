<?php

namespace App\Exceptions;

use Exception;

class PermissionDenyException extends Exception
{
    public function render(){ // Eccezione generata
        return response()->json(["error"=>'Non autenticato.'], 403); // Error 403 Unathorized
    }
}
