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

Route::get('/foto.html', function () {
    return view('foto');
})->name("foto");

Route::get('/contacto.html', function () {
    return view('contacto');
})->name("contacto");

Route::get('/diarios.html', function () {
    return view('diarios');
})->name("diarios");

Route::get('/faq.html', function () {
    return view('faq');
})->name("faq");

Route::get('/privacidad.html', function () {
    return view('privacidad');
})->name("privacidad");

Route::get('/semanales.html', function () {
    return view('semanales');
})->name("semanales");

Route::get('/tyc.html', function () {
    return view('tyc');
})->name("tyc");

Route::get('/thankyou.html', function () {
    return view('thankyou');
})->name("thankyou");

Route::get('/ganadores.html', function () {
    return view('ganadores');
})->name("ganadores");