<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/standards/{id}', 'StandardsController@show');
Route::put('/standards/{id}/propose', 'StandardsController@propose');
Route::put('/standards/{id}/approve', 'StandardsController@approve');
Route::put('/standards/{id}/reject', 'StandardsController@reject');
