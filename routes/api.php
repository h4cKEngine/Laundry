<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WasherController;
use App\Http\Controllers\WashingProgramController;
use App\Http\Controllers\ReservationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Models\Washer;
use App\Models\WashingProgram;
use App\Models\Reservation;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*Route::get('/users/{id}', function ($id) {
    return [
        'lavasciuga' => Washer::find(1)->programmaLavaggio,
        'programma_lav' => WashingProgram::find(1)->lavasciuga
    ];
});*/

/* user ---> visualizzare, aggiungere, eliminare la propria prenotazione
*   admin ---> visualizzare, eliminare tutte le prenotazioni
*/

Route::group(['prefix' => 'washer'], function(){
    // PATCH washer
    Route::patch('{washer}/enable', [WasherController::class, 'abilitaStato']);
    Route::patch('{washer}/disable', [WasherController::class, 'disabilitaStato']);
});

Route::group(['prefix' => 'user'], function(){
    // GET user
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{user}/reservation/', [UserController::class, 'visualizzaPrenotazioniUtente']);

    // DELETE user
    Route::delete('/{user}/reservation/', [UserController::class, 'cancellaPrenotazioniUtente']);
});

Route::group(['prefix' => 'reservation'], function(){
    // GET reservation
    Route::get('/', [ReservationController::class, 'index']);
    Route::get('/reservation/{reservation_parameter}', [ReservationController::class, 'show']);
    
    // DELETE reservation
    Route::delete('/', [ReservationController::class, 'deleteall']);
    Route::delete('/{reserve}', [ReservationController::class, 'destroy']);

    // POST reservation
    Route::post('/', [ReservationController::class, 'store']);
});