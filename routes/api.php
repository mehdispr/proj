<?php

use Illuminate\Http\Request;

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

Route::post('register','RegisterController@register');


Route::prefix("admin")->group(function (){
    Route::get('','AdminController@index');
    Route::get('{id_admin}','AdminController@show');
    Route::post('','AdminController@store');
    Route::post('edit/','AdminController@update');
    Route::post('/activateMod','AdminController@enableMod');
    Route::post('/desactivateMod','AdminController@disableMod');
    Route::delete('{id_admin}','AdminController@destroy');
});

Route::get('moderateur','ModerateurController@index');
Route::get('moderateur/{id_moderateur}','ModerateurController@show');
Route::post('moderateur/','ModerateurController@store');
Route::post('moderateur/{id_moderateur}','ModerateurController@update');
Route::delete('moderateur/{id_moderateur}','ModerateurController@destroy');

Route::get('donateur','DonateurController@index');
Route::get('donateur/{id}','DonateurController@show');
Route::post('donateur/','DonateurController@store');
Route::post('donateur/{id}','DonateurController@update');
Route::delete('donateur/{id}','DonateurController@destroy');

Route::get('demandeur','DemandeurController@index');
Route::get('demandeur/{id}','DemandeurController@show');
Route::post('demandeur/','DemandeurController@store');
Route::post('demandeur/{id}','DemandeurController@update');
Route::delete('demandeur/{id}','DemandeurController@destroy');

Route::prefix('projet')->group(function(){
    
    Route::get('','ProjetController@index');
    Route::get('{id}','ProjetController@show');
    Route::post('','ProjetController@store');
    Route::post('edit/','ProjetController@edit');
    Route::delete('{id}','ProjetController@destroy');
    
    Route::post('recherche/','ProjetController@rechercheNom');
    Route::post('filtre/limiteMontant','ProjetController@limiteMontant');
    Route::post('filtre/orderByMontant','ProjetController@orderByMontant');
    Route::post('filtre/categorie','ProjetController@filtreCat');
    Route::post('retrieve/comments','ProjetController@getComments');

    Route::post('fairedon','ProjetController@faireDon');
    Route::get('get/top','ProjetController@topvisited');
    Route::get('get/new','ProjetController@newProjects');
});

Route::prefix('comment')->group(function(){
    Route::get('','CommentaireController@index');
    Route::get('{id}','CommentaireController@show');
    Route::post('','CommentaireController@create');
    Route::post('edit/{id}','CommentaireController@update');
    Route::delete('{id}','CommentaireController@destroy');
});

Route::prefix('paiment')->group(function(){
    Route::get('','PaiementController@index');
    Route::get('{id}','PaiementController@show');
    Route::post('','PaiementController@create');
    Route::delete('{id}','PaiementController@destroy');
});

Route::prefix('don')->group(function(){
    Route::get('','DonController@index');
    Route::get('{id}','DonController@show');
    Route::post('','DonController@create');
    Route::delete('{id}','DonController@destroy');
});