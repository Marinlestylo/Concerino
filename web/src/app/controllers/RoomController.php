<?php

namespace App\Controllers;

session_start();

use App\Core\App;

class RoomsController{

    public function index(){
        $rooms = App::get('database')->selectAll('lieu');

        return view('rooms', compact('rooms'));
    }
}