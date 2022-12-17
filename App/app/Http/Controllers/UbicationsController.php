<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class UbicationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $files = Storage::disk('public')->files('Files');
        return view('admin.ubications.ubications', compact('files'));
    }

    public function destroy(){
        
    }
    
    public function store(){
        //
        dd(request()->all());
        return redirect()->route('ubications')->with('upload', 'ok');
    }
}
