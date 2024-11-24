<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'EventosController@index')->middleware('auth');


Auth::routes([ 'reset'=>false, 'verify'=>false]);
// Route::resources('eventos', 'EventosController');
Route::resource('eventos', 'EventosController')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home');
Route::delete('/eventos/{id}', 'EventosController@destroy');
