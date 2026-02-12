<?php

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function () {
    return view('welcome');
});
 

Route::get('/contact', function(){
    // return redirect('/contact2', 303);
    return redirect() -> route('contact2');
    // return view('contact', ['nombre' => 'Javier']);
}) -> name('contact');

Route::get('/contact2', function(){
    return view('contact2');
}) -> name('contact2');