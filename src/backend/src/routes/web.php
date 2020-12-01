<?php

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

Auth::routes([
    "register"=>false,
    "reset"=>false,
    "verify"=>false
]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('/ticket', 'TicketController@index')->name('tickets');
Route::get('/ticket/{id}/image', 'TicketController@getImage')->name('ticket/image');
Route::post('/ticket/{id}/aprobar', 'TicketController@aprobar')->name('ticket/aprobar');
Route::post('/ticket/{id}/rechazar', 'TicketController@rechazar')->name('ticket/rechazar');
Route::post('/ticket/{id}/premiar', 'TicketController@premiar')->name('ticket/premiar');
Route::post('/ticket/{id}/despremiar', 'TicketController@despremiar')->name('ticket/despremiar');
Route::get('/ticket/download/{week}', 'TicketController@download')->name('ticket/download');


Route::get('/user', 'UserController@index')->name('users');
Route::post('/user/{id}', 'UserController@update')->name('user/update');

Route::get('/participantes', 'ParticipantesController@index')->name('participantes');