<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WasherController;
use App\Http\Controllers\WashingProgramController;
use App\Http\Controllers\ReservationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Models\User;
// use App\Models\Washer;
// use App\Models\WashingProgram;
// use App\Models\Reservation;

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

/** Metodi HTTP
 * 
 * GET ottenere info
 * POST inserire info
 * PATCH effetturare piccola modifica
 * PUT effetturare Grande modifica
 * DELETE eliminazione info
 */

// Sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User routes
Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'index']); // Visualizza tutti gli utenti
    Route::get('/{user}/reservation/', [UserController::class, 'show']); // Visualizza tutte le prenotazioni dell'utente selezionato

    Route::delete('/{user}/reservation/', [UserController::class, 'cancellaTuttePrenotazioniUtente']); // Elimina tutte le prenotazioni dell'utente selezionato
});

// Washer routes
Route::group(['prefix' => 'washer'], function(){
    Route::get('/', [WasherController::class, 'index']); // Visualizza tutte le lavasciuga
    
    Route::post('/', [WasherController::class, 'store']); // Aggiunge una lavasciuga
    
    Route::patch('{washer}/enable', [WasherController::class, 'abilitaStato']); // Attiva una lavasciuga (già esistente)
    Route::patch('{washer}/disable', [WasherController::class, 'disabilitaStato']); // Disabilita una lavasciuga
    
    Route::delete('/{washer}', [WasherController::class, 'destroy']); // Elimina una lavasciuga
    Route::delete('/', [WasherController::class, 'deleteall']); // Elimina tutte le lavasciuga
});

//WashingProgram routes
Route::group(['prefix' => 'washing_program'], function(){
    Route::get('/', [WashingProgramController::class, 'index']); // Visualizza tutti i programmi lav
    
    Route::post('/', [WashingProgramController::class, 'store']); // Aggiunge un programma lav
    
    Route::patch('/{washer}', [WasherController::class, 'edit']); // Modifica un programma lav

    Route::delete('/{washer}', [WashingProgramController::class, 'destroy']); // Elimina un programma lav
    Route::delete('/', [WashingProgramController::class, 'deleteall']); // Elimina tutti i programmi lav
});


// Reservation routes
Route::group(['prefix' => 'reservation'], function(){
    Route::get('/', [ReservationController::class, 'index']); // Visualizza tutte le prenotazioni
    
    Route::post('/', [ReservationController::class, 'store']); // Aggiunge una prenotazione
    
    Route::patch('/', [ReservationController::class, 'edit']); // Modifica una prenotazione

    Route::delete('/', [ReservationController::class, 'deleteall']); // Elimina tutte le prenotazioni
    Route::delete('/{reservation}', [ReservationController::class, 'destroy']); // Elimina una prenotazione


});