<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            return isset($_COOKIE['JOS_BNM']) ? view('login') : redirect('/');
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
            $request->session()->regenerate();
            $user  = User::where('email', $request->input('inputUserid'))->first();
            return ['tokennya' => $user->createToken($request->input('inputUserid') . 'bebas')->plainTextToken];
        } else {
            return ['message' => 'invalid login'];
        }
    }

    function actionLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
