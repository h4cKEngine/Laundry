<?php

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

// ->middleware('role') controlla se l'user è un admin o è lo stesso utente che può effettuare accesso alla risorsa
// ->middleware('adminrole') controlla se l'user è un admin

// Authorization routes
// Verifica di accesso tramite Sanctum
Route::group(['middleware' => 'auth:sanctum'], function(){
    // User routes
    // URI: /api/user/
    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::get('/', [UserController::class, 'index'])->middleware('adminrole')->name("indexUser"); // Visualizza tutti gli utenti (attivi)
        Route::get('/trashed', [UserController::class, 'trashed'])->middleware('adminrole'); // Visualizza tutti gli utenti nel cestino

        Route::get('/reservation/all', [ReservationController::class, 'index'])->middleware('adminrole')->name("indexReservation"); // Visualizza tutte le prenotazioni
        
        // URI: /api/user/{user}/
        Route::group(['prefix' =>'/{user}'], function(){
            Route::get('/', [UserController::class, 'show'])->middleware('role')->name("show"); // Visualizza l'utente
            
            Route::patch('/', [UserController::class, 'restore'])->middleware('adminrole'); // Annulla Soft Delete un utente
            
            Route::delete('/', [UserController::class, 'destroy'])->middleware('adminrole'); // Soft Delete su un utente
            
            // URI: /api/user/{user}/reservation
            Route::group(['prefix' => 'reservation', 'as' => 'reservation.'], function(){
                Route::get('/', [UserController::class, 'reservationsUser'])->middleware('role')->name("showReservationsUser"); // Visualizza tutte le prenotazioni dell'utente
                
                Route::post('/', [ReservationController::class, 'store'])->middleware('role')->name("store"); // Crea una prenotazione
                
                Route::delete('/all', [UserController::class, 'deletePrenAll'])->middleware('role')->name("deletePrenAll"); // Elimina tutte le prenotazioni dell'utente selezionato
                
                // URI: /api/user/{user}/reservation/{reservation}
                Route::group(['prefix' => '{reservation}'], function(){
                    Route::get('/', [ReservationController::class, 'show'])->middleware('role')->name("show"); // Visualizza la prenotazione dell'utente
                    
                    Route::patch('/', [ReservationController::class, 'update'])->middleware('role')->name("update"); // Modifica una prenotazione
                    
                    Route::delete('/', [ReservationController::class, 'destroy'])->middleware('role')->name("destroy"); // Elimina una prenotazione
                });
            });
        });
    });

    // Washer routes
    // URI: /api/washer/
    Route::group(['prefix' => 'washer', 'as' => 'washer.'], function(){
        Route::get('/', [WasherController::class, 'index'])->name("index"); // Visualizza tutte le lavasciuga
        
        Route::post('/', [WasherController::class, 'store'])->middleware('adminrole')->name("store"); // Crea una lavasciuga
        
        Route::patch('/', [WasherController::class, 'edit'])->middleware('adminrole')->name("edit"); // Modifica una lavasciuga
        
        Route::put('/', [WasherController::class, 'statusAll'])->middleware('adminrole')->name("statusAll"); // Abilita/Disabilita tutte le lavasciuga
        
        // URI: /api/washer/{washer}/
        Route::group(['prefix' => '{washer}'], function(){
            Route::get('/', [WasherController::class, 'show'])->name("show"); // Visualizza la lavasciuga
            
            Route::patch('/', [WasherController::class, 'status'])->middleware('adminrole')->name("status"); // Attiva/Disabilita la lavasciuga

            Route::delete('/', [WasherController::class, 'destroy'])->middleware('adminrole')->name("destroy"); // Elimina la lavasciuga
            });
        });

    // WashingProgram routes
    // URI: /api/washing_program/
    Route::group(['prefix' => 'washing_program', 'as' => 'washing_program.'], function(){
        Route::get('/', [WashingProgramController::class, 'index'])->name("index"); // Visualizza tutti i programmi lav
        
        Route::post('/', [WashingProgramController::class, 'store'])->middleware('adminrole')->name("store"); // Crea il programma lav

        Route::put('/', [WashingProgramController::class, 'statusAll'])->middleware('adminrole')->name("statusAll"); // Abilita/Disabilita tutte i programmi lav
        
        // URI: /api/washing_program/{washing_program}
        Route::group(['prefix' => '{washing_program}'], function(){
            Route::get('/', [WashingProgramController::class, 'show'])->middleware('role')->name("show"); // Modifica il programma lav
            
            Route::patch('/', [WashingProgramController::class, 'update'])->middleware('adminrole')->name("update"); // Modifica il programma lav

            Route::delete('/', [WashingProgramController::class, 'destroy'])->middleware('adminrole')->name("destroy"); // Elimina il programma lav
        });
    });
});
