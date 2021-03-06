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

Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::get('/preguntas-frecuentes', function () {
    return view('faq');
})->name("faq");

Route::get('/terminos-y-condiciones', function () {
    return view('legales');
})->name("legales");

Route::get('/aviso-de-privacidad', function () {
    return view('privacidad');
})->name("privacidad");