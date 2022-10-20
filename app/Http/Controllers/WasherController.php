<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Washer;

class WasherController extends Controller
{
    public function disabilitaStato(Washer $washer){
        $washer->update(['stato' => 0]);
    }

    public function abilitaStato(Washer $washer){
        $washer->update(['stato' => 1]);
    }
}
