<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Washer extends Model
{
    use HasFactory;

    protected $fillable = [
        'marca',
        'disponibile_bool'
    ];

    public function prenotazioneLavasciuga(){
        return $this->hasMany(Reservation::class, 'id_reservation', 'id');
    }

    public function programmaLavaggio(){
        return $this->belongsToMany(WashingProgram::class, 'selectings', 'id_lav', 'id_progr_lav');
    }
}
