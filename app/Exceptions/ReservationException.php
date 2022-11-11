<?php

namespace App\Exceptions;

use Exception;

class ReservationException extends Exception
{
    public function render(){ // Eccezione generata
        return response()->json(['error' => 'Prenotazione non effettuabile, slot non disponibile causa sovrapposizioni.'], 409); // Errore HTTP 409 Conflitto stato attuale della risorsa
    }
}
