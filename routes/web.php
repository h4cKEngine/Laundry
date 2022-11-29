<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* HTTP METHODS

    GET - Request a resurce
    POST - Create a new resurce
    PUT - Update a resurce
    PATCH - Modify a resurce
    DELETE - Delete a resurce
    OPTIONS - Ask the server which verbs are allowed

    GET
    Route::get('/url{parameter}', [Controller::class, 'functionName']);

    POST
    Route::post('/url{parameter}', [Controller::class, 'functionName']);

    UPDATE
    Route::put('/url{parameter}', [Controller::class, 'functionName']);

    PATCH

    Route::patch('/url{parameter}', [Controller::class, 'functionName']);

    DELETE
    Route::delete('/url{parameter}', [Controller::class, 'functionName']);

    Multiple HTTP verbs
    Route::match(['GET', 'POST'], '/url', [Controller::class, 'functionName']);
    Route::any(['GET', 'POST'], '/url', [Controller::class, 'functionName']);
*/

//'prova/{numero?}' --> il ? indica che il paramentro è opzionale, $numero = 2 è il valore di default
// Route::get('prova/{numero?}', function ($numero = 2) {
//     for($i=0; $i<10; $i=$i+1){
//         echo "$i * $numero = ". $i * $numero ."<br>";
//         }
// });

Route::get('/', function () {
    return view('guest');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/carbon', function () {
    return view('carbon');
});

Route::get('/user', function () {
    return view('user');
});

Route::get('/admin', function () {
    return view('admin');
});

