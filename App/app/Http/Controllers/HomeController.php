<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // public function welcome(){
    //     return view('welcome');
    // }

    public function showChangePasswordGet() {
        return view('auth.passwords.change-password');
    }

    public function changePasswordPost(Request $request) {
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            Alert::error('Error de contraseña', 'Tu antigua contraseña no coincide con la que has ingresado.');
            return redirect()->back();
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            // Current password and new password same
            Alert::error('Error de contraseña', 'Tu nueva contraseña no puede ser la misma que la antigua contraseña.');
            return redirect()->back();
        }

        

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        Alert::success('Hecho', 'Tu contraseña ha sido cambiada exitosamente.');

        return redirect()->back();
    }
}
