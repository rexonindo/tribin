<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    function login()
    {
        if (Auth::check()) {
            return redirect('home');
        } else {
            return view('login');
        }
    }

    function actionLogin(Request $request)
    {
        $data = [
            'email' => $request->input('inputUserid'),
            'password' => $request->input('inputPassword'),
            'active' => '1',
        ];

        if (Auth::attempt($data)) {
            return redirect('home');
        } else {
            Session::flash('error', 'Email atau Passwordnya');
            return redirect('/');
        }
    }

    function actionLogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
