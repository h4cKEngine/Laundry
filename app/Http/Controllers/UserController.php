<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{   
    public function VisualizzaPrenotazioni(){
        return ['utenti_chiave' => UserResource::collection(User::all())]; 
    }

}
