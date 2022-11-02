<?php

namespace App\Exceptions;

use Exception;

class PermissionException extends Exception
{
    public function render(){
        return response()->json(['errore' => 'Permesso negato, attributi mancanti']);
    }
}
