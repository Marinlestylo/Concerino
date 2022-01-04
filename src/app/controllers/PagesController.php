<?php

namespace App\Controllers;

class PagesController{
    public function home(){

        return view('index');
    }

    public function login(){
        return view('login');
    }

    public function createAccount(){
        return view('createAccount');
    }
}