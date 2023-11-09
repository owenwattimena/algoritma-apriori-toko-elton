<?php

namespace App\Http\Controllers;

use App\Helpers\AlertFormatter;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->only('username','password');
        $remember = false;

        if( isset($request->remember) ) $remember = true;

        if(Auth::attempt($credentials, $remember))
        {
            return redirect()->intended();
        }
        return redirect()->back()->with(AlertFormatter::danger('Usrname atau password salah!'));
    }
}
