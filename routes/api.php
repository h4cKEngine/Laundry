<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Washer;
use App\Models\WashingProgram;

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

Route::put('/washer/{washer}', [WasherController::class, 'abilitaStato']);

Route::get('/users/all/', [UserController::class,'visualizzaUtenti']);
