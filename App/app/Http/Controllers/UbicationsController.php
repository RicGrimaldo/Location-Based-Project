<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UbicationsController extends Controller
{
    public function index(){

    }

    public function create(){

    }

    public function destroy(){

    }

    public function store(){
        //
        return redirect()->route('ubications')->with('upload', 'ok');
    }
}
