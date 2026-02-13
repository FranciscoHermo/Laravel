<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrimerControlador extends Controller
{
    function index(){
        $post = ['post1', 'post2'];
        // return view('contact', ['post' => $post]);
        return view('contact', ['post' => compact('post')]);
    }

    function otro($post=40, $otro=50){
        echo $post;
        echo $otro;
    }
}
