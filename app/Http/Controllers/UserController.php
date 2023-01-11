<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Http\Resources\UserResource;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return new UserResource($user);
    }

    public function reservationsUser(User $user)
    {
        return ReservationResource::collection($user->prenotazione);
    }

    // Cancella tutte le prenotazioni dell'utente selezionato
    public function deletePrenAll(User $user)
    {
        $user->prenotazione()->delete();
    }

    // Return nazionalità
    // public function nazione(User $user)
    // {
    //     $user->nazionalita();
    // }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // Visualizza tutti gli utenti
    public function index(Request $request)
    {
        return ['utenti' => UserResource::collection(User::all())];
    }

    public function trashed()
    {
        return User::onlyTrashed()->get();
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
        //
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
    public function update(Request $request, User $user)
    {   
        return $request;
        $request->validate([
            'email' => 'string|required',
            'nome' => 'string|required',
            'cognome' => 'string|required',
            'matricola' => 'string|required',
            'nazionalita' => 'string',
            'ruolo' => 'boolean',
            'delete_at' => 'date_format:Y-m-d H:i:s'
        ],[
            'string' => 'Errore, inserire string',
            'integer' => 'Errore, inserire integer',
            'boolean' => 'Errore, inserire boolean',
            'required' => 'Errore, inserire un campo'
        ]);

        $user->update([
            'email' => $request->email,
            'nome' => $request->nome,
            'cognome' => $request->cognome,
            'matricola' => $request-> matricola,
            'nazionalita' => $request->nazionalita,
            'ruolo' => $request->ruolo,
            'delete_at' => $request->stato
        ]);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) // Soft Delete di un User
    {
        $user->tokens()->delete();
        $user->delete();
    }
    
    public function restore($user) // Annulla Soft Delete
    {   
        $utente = User::withTrashed()->findOrFail($user);
        $utente->restore();
    }
}
