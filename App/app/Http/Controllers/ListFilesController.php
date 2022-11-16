<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

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
        $request->file('file-upload')->store('public/Files');
        return redirect()->route('files')->with('upload', 'ok');
    }

}
