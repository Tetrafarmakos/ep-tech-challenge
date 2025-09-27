<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('clients', 'ClientController')
        ->except(['edit', 'update']);

//    Route::controller(JournalsController::class)
//        ->prefix('clients/{client}/journals')
//        ->name('clients.journals.')
//        ->group(function () {
//            Route::get('/', 'index')->name('index');
//            Route::post('/', 'store')->name('store');
//            Route::delete('/{journal}', 'destroy')->name('destroy');
//        });
});
