<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\ReservationResource;

use App\Models\Reservation;
use App\Models\User;
use App\Models\WashingProgram;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Arrays;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'orario' => 'date|date_format:d-m-Y H:i:s|required',
            // Prendilo dal token, 'id_user' => 'integer|required',
            'id_washer' => 'exists:washers,id|required',
            'id_washing_program' => 'exists:washing_programs,id|required',
        ],[
            'date' => 'Errore, inserire datetime',
            'integer' => 'Errore, inserire integer',
            'boolean' => 'Errore inserire boolean',
            'required' => 'Errore, inserire un campo'
        ]);

        
        /**
         *Query da emulare
        
         */
        
        $programma = WashingProgram::findOrFail($request->id_washing_program);
        
        $data_richiesta = strtotime($request->orario);
        
        $giorno_richiesto = date("Y-m-d", $data_richiesta);

        $ora_inizio_richiesta = date("H:i:s", $data_richiesta);

        $ora_fine_prevista = $data_richiesta + strtotime($programma->durata);
        $ora_fine_prevista = date("H:i:s", $ora_fine_prevista);

        $prenotazioni_sovrapponibili = DB::table('reservations')->select('*')
                                                                                                ->join('washing_programs', 'washing_programs.id', '=', 'reservations.id_washing_program')
                                                                                                ->where('id_washer', $request->id_washer)
                                                                                                ->where(function($query) use($ora_inizio_richiesta, $ora_fine_prevista){
                                                                                                    $betweenConds = [DB::raw('CAST("' . $ora_inizio_richiesta . '" AS time)'), DB::raw('CAST("' . $ora_fine_prevista . '" AS time)')];
                                                                                                    $query->whereBetween(
                                                                                                        DB::raw('TIME(orario)'), 
                                                                                                        $betweenConds
                                                                                                    );

                                                                                                    $query->OrWhereBetween(
                                                                                                        DB::raw('ADDTIME(TIME(orario), washing_programs.durata)'), 
                                                                                                        $betweenConds
                                                                                                    );
                                                                                                })->where(DB::raw('DATE(orario)'), $giorno_richiesto);
                                        
        // Se non ci sono che si sovrappongono all'orario richiesto dall'utente, creo la prenotazione!
        
        if(!$prenotazioni_sovrapponibili->count()){
            $query = Reservation::create([
                'orario' => date("Y-m-d H:i:s", $data_richiesta),
                'id_user' => $user->id,
                'id_washer' => $request->id_washer,
                'id_washing_program' => $request->id_washing_program,
            ]);
            return new ReservationResource($query);
        }else{
            return response()->json(['error' => 'Prenotazione non effettuabile, slot non disponibile causa sovrapposizioni.']);
        }

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
