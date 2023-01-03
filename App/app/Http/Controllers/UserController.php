<?php

namespace App\Http\Controllers;

use App\Models\Ubication;

class UserController extends Controller
{
    public function index()
    {
        $ubications = Ubication::all();
        return view('welcome', compact('ubications'));
    }
}
