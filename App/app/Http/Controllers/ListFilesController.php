<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ListFilesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $files = Storage::disk('public')->files('Files');
        $files = $this->paginate($files);
        $files->withPath('/Files');
        return view('admin.Files.files', compact('files'));
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function create(){
        return view('admin.Files.create');
    }

    public function destroy($file){
        Storage::disk('public')->delete('Files/'. $file);
        return redirect()->route('files')->with('delete', 'ok');
    }

    public function store(Request $request){
        $org_file_name = $request->file('file-upload')->getClientOriginalName();
        $extension = pathinfo($org_file_name, PATHINFO_EXTENSION);
        $objExtensions = array('gltf','glb');
        if(in_array($extension, $objExtensions)){
            $new_name = (string) Str::uuid() . '.' . pathinfo($org_file_name, PATHINFO_EXTENSION);
            $request->file('file-upload')->storeAs('public/Files', $new_name);
        }
        else{ 
            $request->file('file-upload')->store('public/Files');
        }
        return redirect()->route('files')->with('upload', 'ok');
    }

}
