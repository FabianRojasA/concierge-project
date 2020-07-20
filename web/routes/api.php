<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register','Api\AuthController@register');
Route::post('/login','Api\AuthController@login');
Route::get('/logout','Api\AuthController@logout')->middleware('auth:api');

Route::apiResource('/people','Api\PersonController')->middleware('auth:api');

//Routes for Person Class
Route::get('/personas','Api\PersonController@index')->middleware('auth:api');
Route::post('/guardarPersona','Api\PersonController@store')->middleware('auth:api');
Route::get('/mostrarPersona','Api\PersonController@show')->middleware('auth:api');
Route::post('/actualizarPersona','Api\PersonController@update')->middleware('auth:api');
Route::post('/eliminarPersona','Api\PersonController@destroy')->middleware('auth:api');
