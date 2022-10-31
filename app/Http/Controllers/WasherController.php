<?php

namespace App\Http\Controllers;

use App\Http\Resources\WasherResource;
use Illuminate\Http\Request;
use App\Models\Washer;

class WasherController extends Controller
{
    public function abilitaStato(Washer $washer){
        $washer->update(['stato' => 1]);
        return new WasherResource($washer);
    }

    public function disabilitaStato(Washer $washer){
        $washer->update(['stato' => 0]);
        return new WasherResource($washer);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ['lavasciuga' => WasherResource::collection(Washer::all())];
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'marca' => 'string|required',
            'stato' => 'boolean|required'
        ],[
            'string' => 'Errore, inserire string',
            'boolean' => 'Errore, inserire integer',
            'required' => 'Errore, inserire un campo'
        ]);
        
        $queryWasher = Washer::create([
            'marca' => $request->marca,
            'stato' => $request->stato
        ]);
        //return new WasherResource($washer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Washer $washer)
    {
        $washer->delete();
    }

    public function deleteall(){
        Washer::truncate();
    }
}
