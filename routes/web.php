<?php

use App\Http\Controllers\PrimerControlador;
use App\Http\Controllers\SegundoControlador;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test',[PrimerControlador::class,'index']);
Route::get('otro/{post}/{otro}',[PrimerControlador::class,'otro']);
