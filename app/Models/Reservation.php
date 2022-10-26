<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public $table='reservations';

    public function lavasciugaPrenota(){
        return $this->belongsTo(Washer::class,  'id_lav', 'id_reservation');
    }

    public function prenotazioneProgrLav(){
        return $this->belongsTo(WashingProgram::class, 'id_progr_lav', 'id_reservation');
    }

    public function utente(){
        return $this->belongsTo(User::class, 'id_utente',  'id_reservation');
    }
}
