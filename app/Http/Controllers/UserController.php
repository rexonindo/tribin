<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroupAccess;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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

        # sekalian daftarkan ke Company Group
        $selectedConnection = Crypt::decryptString($_COOKIE['CGID']);
        $validator = Validator::make([
            'nick_name' => $request->nick_name,
            'connection' => $selectedConnection,
        ], [
            'nick_name' => 'required',
            'connection' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        if (
            DB::table('COMPANY_GROUP_ACCESSES')
            ->where('nick_name', $request->nick_name)
            ->where('connection', $selectedConnection)
            ->whereNull('deleted_at')
            ->count() > 0
        ) {
            return response()->json(['message' => 'Already registered'], 406);
        }

        CompanyGroupAccess::create([
            'nick_name' => $request->nick_name,
            'connection' => $selectedConnection,
            'created_by' => Auth::user()->nick_name,
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
