<?php

namespace App\Controllers;

use App\Core\App;

class VillesController{

    public function index(){
        $villes = App::get('database')->selectAll('ville');

        return view('villes', compact('villes'));// on peut utiliser ['villes => $villes] pour remplacer compact('villes')
    }

    public function store(){
        App::get('database')->insert('ville', [
            'nom' => $_POST['name']
        ]);
        
        return redirect('villes');
    }
}