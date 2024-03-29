<?php

namespace App\Http\Controllers;

use App\Exceptions\PermissionException;
use App\Http\Middleware\Role as MiddlewareRole;
use App\Http\Resources\WasherResource;
use Illuminate\Http\Request;
use App\Models\Washer;
use Illuminate\Support\Facades\DB;

class WasherController extends Controller
{
    public function status(Request $request, Washer $washer)
    {
        $request->validate([
            'stato' => 'required|boolean'
        ]);

        $washer->update(['stato' => $request->stato]);
        return new WasherResource($washer);
    }
    
    public function statusAll(Request $request)
    {
        $request->validate([
            'stato' => 'required|boolean'
        ]);

        $array = Washer::all();
        foreach ($array as $item => $value) {
            $array[$item]->update(['stato' => $request->stato]);
        }
        return WasherResource::collection(Washer::all());
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
    public function show(Washer $washer)
    {
        return new WasherResource($washer);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'exists:washers,id|required',
            'marca' => 'string|required',
            'stato' => 'required'
        ],[
            'string' => 'Errore, inserire string',
            'required' => 'Errore, inserire un campo'
        ]);
        
        $queryWasher = Washer::where('id', $request->id)->update([
            'marca' => $request->marca,
            'stato' => $request->stato
        ]);
        return new WasherResource($queryWasher);
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
            'boolean' => 'Errore, inserire boolean',
            'required' => 'Errore, inserire un campo'
        ]);
        
        $queryWasher = Washer::create([
            'marca' => $request->marca,
            'stato' => $request->stato
        ]);
        return new WasherResource($queryWasher);
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

}
