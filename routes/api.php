<?php

use Illuminate\Support\Facades\Route;

// Arduino routes
Route::post('/apiposts', 'App\Http\Controllers\ApiPostsController@store');
Route::get('/apiposts', 'App\Http\Controllers\ApiPostsController@index');
