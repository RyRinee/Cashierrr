<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signinview()
    {
        return view('auth.signin');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;
            if($role === 'admin'){
                return redirect()->intended('adminDash');
            }elseif($role === 'employee'){
                return redirect()->intended('employeeDash');
            }elseif($role === 'customer'){
                return redirect()->intended('customerDash');
            }
        }else{
            return redirect('/login')->with('failed', 'Email atau Password Salah');
        }
    }
}
