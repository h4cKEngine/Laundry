<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $timestamps = false;
    
    protected $fillable = [
        'email',
        'password',
        'nome',
        'cognome',
        'ruolo'
    ];
    
    protected $dates = [
        'deleted_at'
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
    
    // ----------------- Examples Getter and Setter ------------------ //
    private $numero;
    
    public function getElem(){
        return $this->numero;
    }
    
    public function setElem($num){
        $this->numero = $num;
    }

    // public function isAdmin(){
    //     return $this->ruolo == enumUser::admin;
    // }
}

// esempio Creazione classe astratta enum per selezione del ruolo
// abstract class enumUser {
//     public const user = 0;
//     public const admin = 1;
//     public function isAdmin();
// }