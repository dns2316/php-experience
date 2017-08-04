<?php

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
//namespace App\Http\Controllers;

Route::get('/', function () {
    return view('welcome', [
        'name' => 'World'
    ]);
});

Route::get('movie', 'MovieController@index');
Route::get('movie/{id}', 'MovieController@show');
Route::post('/movie/create','MovieController@store');