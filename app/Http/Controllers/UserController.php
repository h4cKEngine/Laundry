<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{   
    public function index(){
        return ['utenti_chiave' => UserResource::collection(User::all())]; 
    }

    public function VisualizzaPrenotazioni(){
        return ['utenti_chiave' => UserResource::collection(Reservation::where())]; 
    }

}
