<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Http\Resources\UserResource;

use App\Models\Reservation;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Visualizza tutte le prenotazioni dell'utente selezionato
    public function show(User $user)
    {
        return ReservationResource::collection($user->prenotazione);
    }

    // Cancella tutte le prenotazioni dell'utente selezionato
    public function cancellaTuttePrenotazioniUtente(User $user)
    {
        $user->prenotazione()->delete();
    }

    // Cancella la singola prenotazione dell'utente selezionato
    public function cancellaPrenotazioneUtente(User $user)
    {
        $user->prenotazione->delete();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // Visualizza tutti gli utenti
    public function index()
    {
        return ['utente' => UserResource::collection(User::all())];
    }


    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'string|required',
            'nome' => 'string|required',
            'cognome' => 'string|required',
            'password' => 'string|required',
            'ruolo' => 'boolean|required'
        ],[
            'string' => 'Errore, inserire string',
            'boolean' => 'Errore, inserire boolean',
            'required' => 'Errore, inserire un campo'
        ]);
        
        $query = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'nome' => $request->nome,
            'cognome' => $request->cognome,
            'ruolo' => $request->ruolo
        ]);
        //return new UserResource($query);
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
