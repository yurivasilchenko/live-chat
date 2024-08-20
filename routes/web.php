<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\PusherController@index');
Route::post('broadcast', 'App\Http\Controllers\PusherController@broadcast'); // Change from GET to POST
Route::post('receive', 'App\Http\Controllers\PusherController@receive'); // Assuming this should also be POST
