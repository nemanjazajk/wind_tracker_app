<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Auth::routes(['register' => false]);
Route::get('/', function () {
    return view('home');
})->middleware('auth');

Route::get('/api/user', function (Request $request) {
    return $request->user();
})->middleware('auth');
// Data for controll board
Route::get('/api/posts', 'App\Http\Controllers\ApiWindController@index')->middleware('auth');
Route::get('/api/posts/get', 'App\Http\Controllers\ApiWindController@get')->middleware('auth');
// Date for Histroy chart
Route::post('/api/date', 'App\Http\Controllers\DatumController@index')->middleware('auth');
Route::get('/api/date/current', 'App\Http\Controllers\DatumController@get')->middleware('auth');
// Settings
Route::post('/api/settings', 'App\Http\Controllers\FormController@store')->middleware('auth');
Route::get('/api/settings', 'App\Http\Controllers\FormController@get')->middleware('auth');