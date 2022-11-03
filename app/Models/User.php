<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Creazione classe astratta enum per selezione del ruolo
// abstract class enumUser {
//     public const user = 0;
//     public const admin = 1;
// }

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    //Examples private, public, protected Getter and Setter
    // private $numero;

    // public function getElem(){
    //     echo $this->numero;
    // }

    // public function setElem($num){
    //     $this->numero = $num;
    // }

    public $timestamps = false;
    
    protected $fillable = [
        'email',
        'password',
        'nome',
        'cognome',
        'ruolo',
        'stato'
    ];

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'password'
    ];

    public function prenotazione(){
        return $this->hasMany(Reservation::class, 'id_user', 'id');
    }

    // public function isAdmin(){
    //     return $this->ruolo == enumUser::admin;
    // }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}
