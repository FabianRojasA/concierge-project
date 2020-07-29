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

Route::apiResource('/people','Api\PersonController');

//Routes for Person Class
Route::get('/personas','Api\PersonController@index')->middleware('auth:api');
Route::post('/guardarPersona','Api\PersonController@store');
Route::get('/mostrarPersona','Api\PersonController@show');
Route::post('/actualizarPersona','Api\PersonController@update')->middleware('auth:api');
Route::post('/eliminarPersona','Api\PersonController@destroy')->middleware('auth:api');

//Routes for Visit Class
Route::get('/visitas','Api\VisitController@index')->middleware('auth:api');
Route::post('/guardarVisita','Api\VisitController@store')->middleware('auth:api');
Route::get('/registro','Api\VisitController@visits')->middleware('auth:api');
Route::get('/direccion','Api\VisitController@toAdress')->middleware('auth:api');


Route::get('registro','Api\VisitController@visits');
Route::get('registro/{adress}','Api\VisitController@toAdress');
