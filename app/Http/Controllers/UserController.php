<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $RSRoles = Role::select('*')->get();
        return view('user_registration', ['RSRoles' => $RSRoles]);
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:App\Models\User|email:rfc,dns',
            'name' => 'required',
            'nick_name' => 'required|unique:App\Models\User',
            'password' => 'required|min:8',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        User::create([
            'name' => $request->name,
            'nick_name' => $request->nick_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'active' => 1,
            'role' => $request->role,
        ]);
        return ['msg' => 'OK'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'email',
            'name',
        ];
        $RS = User::select('*')->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')->get();
        return ['data' => $RS];
    }
}
