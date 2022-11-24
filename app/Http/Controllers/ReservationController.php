<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Washer;
use App\Models\WashingProgram;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exceptions\ReservationException;
use Exception;
use Carbon\Carbon;

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
    public function store(Request $request, User $user, Reservation $reservation)
    {   
        // Validazione dei campi e errori
        $request->validate([
            'orario' => 'date|date_format:d-m-Y H:i:s|required',
            // Si può ottenere dal token, 'id_user' => 'integer|required',
            'id_washer' => 'exists:washers,id|required',
            'id_washing_program' => 'exists:washing_programs,id|required',
        ],[
            'date' => 'Errore, inserire datetime',
            'integer' => 'Errore, inserire integer',
            'boolean' => 'Errore inserire boolean',
            'required' => 'Errore, inserire un campo'
        ]);

        $lavatrice = Washer::find($request->id_washer);
        if(!$lavatrice->stato)
            throw new Exception("Lavatrice non disponibile");
        
        $programma = WashingProgram::find($request->id_washing_program);
        if(!$programma->stato)
            throw new Exception("Programma lavaggio non disponibile");
        
        $programma = WashingProgram::findOrFail($request->id_washing_program);
        $data_richiesta = strtotime($request->orario);
        $giorno_richiesto = date("Y-m-d", $data_richiesta);
        $ora_inizio_richiesta = date("H:i:s", $data_richiesta);
        $ora_fine_prevista = date("H:i:s", $data_richiesta + strtotime($programma->durata));

        // Controlla se la Data e L'Ora richiesti sono antecedenti o successivi a quelli correnti
        $oggi = strtotime(Carbon::now());
        if($data_richiesta < $oggi)
            return response()->json(["Data e Ora antecedente a quella attuali"]);

        // Controlla se l'Orario è compreso nell'intervallo orario
        if( !($data_richiesta >= strtotime($giorno_richiesto . " 08:00:00") && $data_richiesta <= strtotime($giorno_richiesto . " 20:00:00")) )
            return response()->json(["Orario non compreso nell'intervallo orario 8:00 - 20:00"]);

        // Controlla se il giorno selezionato è valido
        $weekend = [0, 6];
        $giorno_settimana = Carbon::createFromFormat("Y-m-d", $giorno_richiesto)->dayOfWeek; // numero giorno della settimana
        if( in_array($giorno_settimana, $weekend) )
            return response()->json(["Giorno selezionato non disponibile: Sabato e Domenica locale chiuso"]);

        $prenotazioni_sovrapponibili = DB::table('reservations')->select('*')
                                                        ->join('washing_programs', 'washing_programs.id', '=', 'reservations.id_washing_program')
                                                        ->where('id_washer', $request->id_washer)
                                                        ->where(DB::raw('DATE(orario)'), $giorno_richiesto)
                                                        ->where(function($query) use($ora_inizio_richiesta, $ora_fine_prevista){
                                                            $betweenConds = [
                                                                DB::raw('CAST("' . $ora_inizio_richiesta . '" AS time)'), 
                                                                DB::raw('CAST("' . $ora_fine_prevista . '" AS time)')
                                                            ];
                                                            
                                                            $query->whereBetween(
                                                                DB::raw('TIME(orario)'), 
                                                                $betweenConds
                                                            );

                                                            $query->OrWhereBetween(
                                                                DB::raw('ADDTIME(TIME(orario), washing_programs.durata)'), 
                                                                $betweenConds
                                                            );    
                                                        });
        // Se non ci sono che si sovrappongono all'orario richiesto dall'utente, creo la prenotazione
        if(!$prenotazioni_sovrapponibili->count()){ // $prenotazioni_sovrapponibili == 0 nessuna prenotazione da conflitto
            $query = Reservation::create([
                'orario' => date("Y-m-d H:i:s", $data_richiesta),
                'id_user' => $user->id,
                'id_washer' => $request->id_washer,
                'id_washing_program' => $request->id_washing_program,
            ]);
            return new ReservationResource($query);
        }else{
           throw new ReservationException;
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Reservation $reservation)
    {   
        $request->validate([
            'orario' => 'date|date_format:d-m-Y H:i:s|required',
            //'id_user' => 'integer|required',
            'id_washer' => 'exists:washers,id|required',
            'id_washing_program' => 'exists:washing_programs,id|required',
        ],[
            'integer' => 'Errore, inserire integer',
            'date' => 'Errore, inserire datetime',
            'required' => 'Errore, inserire un campo'
        ]);

        $prenotazione = Reservation::find($reservation->id);
        if(!$prenotazione)
            throw new Exception("Prenotazione non trovata");
        
        $oggi = strtotime(Carbon::now());
        if(strtotime($prenotazione->orario) < $oggi)
            throw new Exception("Prenotazione scaduta");
        
        $lavatrice = Washer::find($request->id_washer);
        if(!$lavatrice->stato)
            throw new Exception("Lavatrice non disponibile");
        
        $programma = WashingProgram::find($request->id_washing_program);
        if(!$programma->stato)
            throw new Exception("Programma lavaggio non disponibile");
    
        
        $programma = WashingProgram::findOrFail($request->id_washing_program);
        $data_richiesta = strtotime($request->orario);
        $giorno_richiesto = date("Y-m-d", $data_richiesta);
        $ora_inizio_richiesta = date("H:i:s", $data_richiesta);
        $ora_fine_prevista = date("H:i:s", $data_richiesta + strtotime($programma->durata));


        // Controlla se la Data e L'Ora richiesti sono antecedenti o successivi a quelli correnti
        $oggi = strtotime(Carbon::now());
        if($data_richiesta < $oggi)
            return response()->json(["Data e Ora antecedente a quella attuali"]);

        // Controlla se l'Orario è compreso nell'intervallo orario
        if( !($data_richiesta >= strtotime($giorno_richiesto . " 08:00:00") && $data_richiesta <= strtotime($giorno_richiesto . " 20:00:00")) )
            return response()->json(["Orario non compreso nell'intervallo orario 8:00 - 20:00"]);

        // Controlla se il giorno selezionato è valido
        $weekend = [0, 6]; // 0 == domenica  -  6 == sabato
        $giorno_settimana = Carbon::createFromFormat("Y-m-d", $giorno_richiesto)->dayOfWeek; // numero giorno della settimana
        if( in_array($giorno_settimana, $weekend) )
            return response()->json(["Giorno selezionato non disponibile: Sabato e Domenica locale chiuso"]);


        $prenotazioni_sovrapponibili = DB::table('reservations')->select('*')
                                                        ->join('washing_programs', 'washing_programs.id', '=', 'reservations.id_washing_program')
                                                        ->where('id_washer', $request->id_washer)
                                                        ->where(DB::raw('DATE(orario)'), $giorno_richiesto)
                                                        ->where('reservations.id', '<>', $prenotazione->id)
                                                        ->where(function($query) use($ora_inizio_richiesta, $ora_fine_prevista){
                                                            $betweenConds = [
                                                                DB::raw('CAST("' . $ora_inizio_richiesta . '" AS time)'), 
                                                                DB::raw('CAST("' . $ora_fine_prevista . '" AS time)')
                                                            ];
                                                            
                                                            $query->whereBetween(
                                                                DB::raw('TIME(orario)'), 
                                                                $betweenConds
                                                            );

                                                            $query->OrWhereBetween(
                                                                DB::raw('ADDTIME(TIME(orario), washing_programs.durata)'), 
                                                                $betweenConds
                                                            );    
                                                        });
        // Controlla se ci sono prenotazioni disponibili
        if(!$prenotazioni_sovrapponibili->count()){ 
            $query = Reservation::create([
                'orario' => date("Y-m-d H:i:s", $data_richiesta),
                'id_user' => $user->id,
                'id_washer' => $request->id_washer,
                'id_washing_program' => $request->id_washing_program,
            ]);

            // Elimina la precedente prenotazione
            $prenotazione->delete();
            return new ReservationResource($query);
        }else{
            return new Exception("Prenotazione sovrapposta ad una già esistente");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Reservation $reservation)
    {
       return new ReservationResource($reservation);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Reservation $reservation){ 
            $reservation->delete();
    }
}
