<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WashingProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'prezzo',
        'durata'
    ];

    public function lavasciuga(){
        return $this->belongsToMany(Washer::class, 'selectings', 'id_progr_lav',  'id_lav');
    }

    public function prenotazioneProgrammaLav(){
        return $this->hasMany(Reservation::class, 'id_progr_lav', 'id');
    }
}
