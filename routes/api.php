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

Route::resource('Pharmacie', 'Pharmacie_controller');
Route::resource('Livreur', 'Livreur_controller');
Route::resource('Admin_pharmacie', 'Admin_pharmacie_Controller');
Route::resource('Client', 'Client_Controller');
Route::resource('Demande', 'Demande_Controller');
Route::GET('get_demande_by_livreur/{id}','Demande_Controller@get_demande_by_livreur');
Route::GET('get_demande_by_pharmacie/{id}','Demande_Controller@get_demande_by_pharmacie');
Route::GET('get_demande_by_client/{id}','Demande_Controller@get_demande_by_client');
Route::POST('Login','Auth_controller@login');
Route::POST('Register','Auth_controller@register');

