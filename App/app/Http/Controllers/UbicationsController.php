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
        return response()->json([
            'filename' => $request->filename,
            'file_type' => $request->file_type,
            'tag' => $request->tag,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'text' => $request->text,
        ]);
    }
}
