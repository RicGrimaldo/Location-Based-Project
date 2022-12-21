<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    
    public function store(Request $request){
        dd($request->all());
        return Response::json($request->all(), 200);
    }
}
