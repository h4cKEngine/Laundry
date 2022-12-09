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

    GET - Request a resource
    POST - Create a new resource
    PUT - Update a resource
    PATCH - Modify a resource
    DELETE - Delete a resource
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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/carbon', function () {
    return view('carbon');
});

Route::get('/signup', function () {
    return view('signup');
})->name('register');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'auth'], function(){
    Route::get('/user', function () {
        return view('user');
    });
    
    Route::get('/admin', function () {
        return view('admin');
    });

    Route::get('/logout', function () {
        return route('logout');
    });
});