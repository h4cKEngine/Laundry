<?php

namespace App\Http\Controllers;

use App\Http\Resources\WashingProgramResource;
use App\Models\WashingProgram;
use Illuminate\Http\Request;

class WashingProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Visualizza tutti i programmi lavaggio
    public function index()
    {
        return ['programma' => WashingProgramResource::collection(WashingProgram::all())];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'nome' => 'string|required',
            'prezzo' => 'integer|required',
            'durata' => 'date_format:H:i:s|required'    // date_format:Y-m-d H:i:s 
        ],[
            'string' => 'Errore, inserire string',
            'integer' => 'Errore, inserire integer',
            'date_format' => 'Errore, inserire time',
            'required' => 'Errore, inserire un campo'
        ]);
        
        $query = WashingProgram::create([
            'nome' => $request->nome,
            'prezzo' => $request->prezzo,
            'durata' => $request->durata
        ]);
        //return new WashingProgramResource($query);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function update(Request $request, $washing_program)
    {
        WashingProgram::where('id', '=', $washing_program)->update([
            'nome' => $request->nome,
            'prezzo' => $request-> prezzo,
            'durata' => $request->durata,
            'stato' => $request->stato
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Elimina programma lav
    public function destroy(WashingProgram $washing_program)
    {
        $washing_program->delete();
    }

    public function disable(WashingProgram $washing_program)
    {
        $washing_program->update(['stato' => 0]);
    }

    public function enable(WashingProgram $washing_program)
    {
        $washing_program->update(['stato' => 1]);
    }

    public function disableAll(Request $request)
    {
        $array = WashingProgram::all();
        foreach ($array as $item => $value) {
            $array[$item]->update(['stato' => 0]);
        }
    }

    public function enableAll(Request $request)
    {
        $array = WashingProgram::all();
        foreach ($array as $item => $value) {
            $array[$item]->update(['stato' => 1]);
        }
    }
}
