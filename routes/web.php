<?php

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function () {
    return view('welcome');
});
 

// Route::get('/test', function(){
    // return "Welcome";
// });

Route::get('/test', function(){
    return View('test');
});

Route::get('/crud', function(){

    $age = 21;
    $data = ['name' => 'Javier', 'age' => $age];

    return View('crud/index' ,$data);
});