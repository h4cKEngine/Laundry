<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WasherController;
use App\Http\Controllers\WashingProgramController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
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

// ->middleware('role') controlla se l'user è un admin o è lo stesso utente che può effettuare accesso alla risorsa
// ->middleware('adminrole') controlla se l'user è un admin

// Accesso tramite Sanctum
Route::group(['prefix' => 'auth'], function(){
    Route::post('/register', [AuthController::class, 'register']); // Registrazione

    Route::post('/login', [AuthController::class, 'login']); // Login

    Route::delete('/logout', [AuthController::class, 'logout'])->middleware('role'); // Logout
});

// User routes
Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'index'])->middleware('adminrole'); // Visualizza tutti gli utenti

    Route::get('/reservation/all', [ReservationController::class, 'index'])->middleware('adminrole'); // Visualizza tutte le prenotazioni
    
    // URI: /api/user/{user}/
    Route::group(['prefix' =>'/{user}'], function(){
        Route::patch('/', [UserController::class, 'status'])->middleware('adminrole'); // Attiva/Disattiva un utente

        Route::put('/', [UserController::class, 'statusAll'])->middleware('adminrole'); // Attiva/Disattiva tutti gli utenti
        
        Route::delete('/', [UserController::class, 'destroy'])->middleware('adminrole'); // Elimina un utente
        // URI: /api/user/{user}/reservation
        Route::group(['prefix' => 'reservation'], function(){
            Route::get('/', [UserController::class, 'show'])->middleware('role'); // Visualizza tutte le prenotazioni dell'utente
            
            Route::post('/', [ReservationController::class, 'store'])->middleware('role'); // Crea una prenotazione
            
            Route::patch('/', [ReservationController::class, 'update'])->middleware('adminrole'); // Modifica una prenotazione
            
            Route::delete('/', [ReservationController::class, 'destroy'])->middleware('role'); // Elimina una prenotazione
            
            Route::delete('/all', [UserController::class, 'deleteAll'])->middleware('role'); // Elimina tutte le prenotazioni dell'utente selezionato
        });
    });
});

// Washer routes
// URI: /api/{washer}/
Route::group(['prefix' => 'washer'], function(){
    Route::get('/', [WasherController::class, 'index'])->middleware('role'); // Visualizza tutte le lavasciuga
    
    Route::post('/', [WasherController::class, 'store'])->middleware('adminrole'); // Aggiunge una lavasciuga
    
    Route::patch('/{washer}', [WasherController::class, 'status'])->middleware('adminrole'); // Attiva/Disabilita una lavasciuga (già esistente)
    
    Route::put('/', [WasherController::class, 'statusAll'])->middleware('adminrole'); // Abilita/Disabilita tutte le lavasciuga

    Route::delete('/{washer}', [WasherController::class, 'destroy'])->middleware('adminrole'); // Elimina una lavasciuga
});

// WashingProgram routes
Route::group(['prefix' => 'washing_program'], function(){
    Route::get('/', [WashingProgramController::class, 'index'])->middleware('role'); // Visualizza tutti i programmi lav
    
    Route::post('/', [WashingProgramController::class, 'store'])->middleware('adminrole'); // Aggiunge un programma lav

    Route::put('/', [WashingProgramController::class, 'statusAll'])->middleware('adminrole'); // Abilita/Disabilita tutte i programmi lav
    
    Route::group(['prefix' => '{washing_program}'], function(){
        Route::patch('/', [WashingProgramController::class, 'status'])->middleware('adminrole'); // Abilita/Disabilita un programma lav
        Route::patch('/update', [WashingProgramController::class, 'update'])->middleware('adminrole'); // Modifica un programma lav

        Route::delete('/', [WashingProgramController::class, 'destroy'])->middleware('adminrole'); // Elimina un programma lav
    });  
});

