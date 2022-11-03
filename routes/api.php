<?php

use App\Http\Controllers\AuthController;
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

/** Metodi HTTP per l'archittettura REST (REpresentational State Transfer), ovvero metodi CRUD (Create Read Update Delete)
 * 
 * GET ottenere info
 * POST inserire info
 * PATCH effetturare piccola modifica
 * PUT effetturare Grande modifica
 * DELETE eliminazione info
 * 
 */

// Sanctum
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//->middleware('role') controlla se l'user è un admin o è lo stesso utente che può effettuare accesso alla risorsa
//->middleware('adminrole') controlla se l'user è un admin

// Accesso tramite Sanctum
Route::group(['prefix' => 'auth'], function(){
    Route::post('/register', [AuthController::class, 'register']); // Registrazione

    Route::post('/login', [AuthController::class, 'login']); // Login

    Route::delete('/logout', [AuthController::class, 'logout']); // Logout
});

// User routes
Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'index'])->middleware('adminrole'); // Visualizza tutti gli utenti
    Route::get('/{user}/reservation/', [UserController::class, 'show'])->middleware('role'); // Visualizza tutte le prenotazioni dell'utente selezionato

    Route::patch('/{user}', [UserController::class, 'enable'])->middleware('adminrole'); // Attiva un utente
    Route::patch('/{user}', [UserController::class, 'disable'])->middleware('adminrole'); // Disattiva un utente

    //Route::delete('/{user}', [UserController::class, 'destroy']); // Elimina un utente
    Route::delete('/{user}/reservation/', [UserController::class, 'cancellaTuttePrenotazioniUtente'])->middleware('role'); // Elimina tutte le prenotazioni dell'utente selezionato
});

// Reservation routes
Route::group(['prefix' => 'reservation'], function(){
    Route::get('/', [ReservationController::class, 'index'])->middleware('role'); // Visualizza tutte le prenotazioni
    
    Route::post('/', [ReservationController::class, 'store'])->middleware('role'); // Aggiunge una prenotazione
    
    Route::patch('/{reservation}', [ReservationController::class, 'update'])->middleware('adminrole'); // Modifica una prenotazione

    //Route::delete('/', [ReservationController::class, 'deleteAll']); // Elimina tutte le prenotazioni
    Route::delete('/{reservation}', [ReservationController::class, 'destroy'])->middleware('role'); // Elimina una prenotazione
});

// Washer routes
Route::group(['prefix' => 'washer'], function(){
    Route::get('/', [WasherController::class, 'index'])->middleware('role'); // Visualizza tutte le lavasciuga
    
    Route::post('/', [WasherController::class, 'store'])->middleware('adminrole'); // Aggiunge una lavasciuga
    
    Route::patch('/{washer}/enable', [WasherController::class, 'abilitaStato'])->middleware('adminrole'); // Attiva una lavasciuga (già esistente)
    Route::patch('/{washer}/disable', [WasherController::class, 'disabilitaStato'])->middleware('adminrole'); // Disabilita una lavasciuga (già esistente)
    
    Route::put('/disableall', [WasherController::class, 'disableAll'])->middleware('adminrole'); // Abilita tutte le lavasciuga
    Route::put('/enableall', [WasherController::class, 'enableAll'])->middleware('adminrole'); // Disabilita tutte le lavasciuga
    
    Route::delete('/{washer}', [WasherController::class, 'destroy'])->middleware('adminrole'); // Elimina una lavasciuga
});

//WashingProgram routes
Route::group(['prefix' => 'washing_program'], function(){
    Route::get('/', [WashingProgramController::class, 'index'])->middleware('role');; // Visualizza tutti i programmi lav
    
    Route::post('/', [WashingProgramController::class, 'store'])->middleware('adminrole'); // Aggiunge un programma lav
    
    Route::patch('/{washing_program}/update', [WashingProgramController::class, 'update'])->middleware('adminrole'); // Modifica un programma lav
    Route::patch('/{washing_program}/disable', [WashingProgramController::class, 'disable'])->middleware('adminrole'); // Disabilita un programma lav
    Route::patch('/{washing_program}/enable', [WashingProgramController::class, 'enable'])->middleware('adminrole'); // Abilita un programma lav
    
    Route::put('/disableall', [WashingProgramController::class, 'disableAll'])->middleware('adminrole'); // Abilita tutte le lavasciuga
    Route::put('/enableall', [WashingProgramController::class, 'enableAll'])->middleware('adminrole'); // Disabilita tutte le lavasciuga

    //Route::delete('/{washing_program}', [WashingProgramController::class, 'destroy'])->middleware('adminrole'); // Elimina un programma lav
});

