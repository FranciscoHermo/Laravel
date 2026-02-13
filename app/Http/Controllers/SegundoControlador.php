<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SegundoControlador extends Controller
{
    function index(){
        $name ="Javier";
        return view('contact', ['name' => $name]);
    }
}
