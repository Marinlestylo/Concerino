<?php

namespace App\Controllers;

session_start();

use App\Core\App;

class ConcertsController{

    public function index(){
        $concerts = App::get('database')->selectAll('concert');

        return view('concerts', compact('concerts'));
    }
}