<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        $data = request()->validate([
            'tag' => 'required',
            'file' => 'required',
            'file_type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'text' => '',
        ]);
        if(isset($request->selectedFilePath)){
            $path = $request->selectedFilePath;
        }
        else{
            //  El path será el creado al guardar el archivo
            $org_file_name = $request->file('file')->getClientOriginalName();
            $extension = pathinfo($org_file_name, PATHINFO_EXTENSION);
            $objExtensions = array('gltf','glb');
            if(in_array($extension, $objExtensions)){
                $new_name = (string) Str::uuid() . '.' . pathinfo($org_file_name, PATHINFO_EXTENSION);
                $path = $request->file('file')->storeAs('public/Files', $new_name);
            }
            else{ 
                $path = $request->file('file')->store('public/Files');
            }
        }
        $id = DB::table('users')->insertGetId(
            [
                'tag' => $request->tag, 
                'file' => $path,
                'file_type' => $request->file_type,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'text' => $request->text,
            ]
        );
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
