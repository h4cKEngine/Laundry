<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\ReservationResource;

use App\Models\Reservation;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ['prenotazioni' => ReservationResource::collection(Reservation::all())];
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
            'orario' => 'date|required',
            'id_user' => 'integer|required',
            'id_washer' => 'integer|required',
            'id_washing_program' => 'integer|required',
            'stato' => 'boolean'
        ],[
            'date' => 'Errore, inserire datetime',
            'integer' => 'Errore, inserire integer',
            'boolean' => 'Errore inserire boolean',
            'required' => 'Errore, inserire un campo'
        ]);
        
        $query = Reservation::create([
            'orario' => $request->orario,
            'id_user' => $request->id_user,
            'id_washer' => $request->id_washer,
            'id_washing_program' => $request->id_washing_program,
            'stato' => $request->stato
        ]);
        //return new ReservationResource($query);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
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
    public function update(Request $request, $reservation)
    {
        Reservation::where('id', '=', $reservation)->update([
            'orario' => $request->orario,
            //'id_user' => $request->id_user,
            'id_washer' => $request-> id_washer,
            'id_washing_program' => $request->id_washing_program,
            'stato' => $request->stato
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation){ // Usare Sanctum
            $reservation->delete();
    }

    // // Elimina tutte le prenotazioni di tutti gli utenti, svuota la tabella reservations
    // public function deleteall(){
    //     Reservation::truncate();
    // }
}
