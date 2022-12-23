<?php

namespace App\Http\Controllers;

use App\Models\Ubication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


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
        $validator = Validator::make($request->all(), [
            'tag' => 'required|unique:ubications',
            'file' => '',
            'file_type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'text' => '',
        ],
        [
            'tag.unique' => 'La etiqueta ya existe, intente con otra distinta.'
        ]
    );
        
        if($validator->fails()) {
            // In the case the user insert a tag that already exists
            return response()->json($validator->messages(), 422);
        }

        //  In the case that a server's file is selected, therefore, the path already exists
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
                $tmp_path = $request->file('file')->storeAs('public/Files', $new_name);
                $path = Storage::url($tmp_path);
            }
            else{ 
                $tmp_path = $request->file('file')->store('public/Files');
                $path = Storage::url($tmp_path);
            }
        }
        $id = Ubication::create(
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
