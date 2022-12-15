<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UbicationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.ubications.ubications');
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
