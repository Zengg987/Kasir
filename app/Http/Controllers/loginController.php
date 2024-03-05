<?php

namespace App\Http\Controllers;
use illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class loginController extends Controller
{
    public function show(){
        return Inertia::render('Login');
    }

    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);


        if(Auth::attempt(['username' => $request->username,
        'password' => $request->password, 'role'=>'admin'])){
            return redirect('/admin');

        }elseif(Auth::attempt(['username' => $request -> username,
        'password' => $request -> password, 'role' => 'petugas'])){
            return redirect('/petugas');
        }
        else{
            return redirect('/');
        }

    }

    public function logout(){
        Auth::logout();
        return redirect("/");
    }
}