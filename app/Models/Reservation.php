<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'orario',
        'id_user',
        'id_washer',
        'id_washing_program'
    ];

    protected $guarded = [
        'id'
    ];

    public function utente(){
        return $this->belongsTo(User::class, 'id_user',  'id');
    }

    public function lavasciugaPrenota(){
        return $this->belongsTo(Washer::class,  'id_lav', 'id');
    }

    public function prenotazioneProgrLav(){
        return $this->belongsTo(WashingProgram::class, 'id_progr_lav', 'id');
    }

}
