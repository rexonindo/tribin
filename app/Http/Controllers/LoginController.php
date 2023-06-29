<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroupAccess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    function login()
    {
        if (Auth::check()) {
            return redirect('home');
        } else {
            unset($_COOKIE['CGID']);
            unset($_COOKIE['CGNM']);
            setcookie('CGID', '-', -1, '/');
            setcookie('CGNM', '-', -1, '/');
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
            $request->session()->regenerate();
            $user  = User::where('email', $request->input('inputUserid'))->first();
            $RSCompany = CompanyGroupAccess::select('COMPANY_GROUP_ACCESSES.connection', 'name')
                ->leftJoin("COMPANY_GROUPS", "COMPANY_GROUP_ACCESSES.connection", "=", "COMPANY_GROUPS.connection")
                ->whereNull('deleted_at')
                ->where('nick_name', Auth::user()->nick_name)
                ->get();
            $company = ['connection' => '-', 'name' => '-'];
            foreach ($RSCompany as $r) {
                $company['connection'] = Crypt::encryptString($r->connection);
                $company['name'] = $r->name;
            }
            return [
                'tokennya' => $user->createToken($request->input('inputUserid') . 'bebas')->plainTextToken, 'data' => $company
            ];
        } else {
            return ['message' => 'invalid login'];
        }
    }

    function actionLogout(Request $request)
    {
        Auth::logout();
        unset($_COOKIE['CGID']);
        unset($_COOKIE['CGNM']);
        setcookie('CGID', '-', -1, '/');
        setcookie('CGNM', '-', -1, '/');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
