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

class UserController extends Controller
{
    private $RSRoles = [];

    public function __construct()
    {
        $this->RSRoles = Role::select('*')->get();
    }

    public function index()
    {
        return view('user_registration', ['RSRoles' => $this->RSRoles]);
    }

    function formManagement()
    {
        return view('user_management', ['RSRoles' => $this->RSRoles]);
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
        $RS = User::select('*')
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')->get();
        return ['data' => $RS];
    }

    function getPerCompanyGroup()
    {
        $RS = User::select('users.*', 'description')
            ->leftJoin('roles', 'role', '=', 'roles.name')
            ->leftJoin('COMPANY_GROUP_ACCESSES', 'users.nick_name', '=', 'COMPANY_GROUP_ACCESSES.nick_name')
            ->where('connection', Crypt::decryptString($_COOKIE['CGID']))
            ->whereNull('deleted_at')
            ->get();
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        if (User::where('id', '!=', $request->id)
            ->where('email', '=', $request->email)->count()
        ) {
            return response()->json(['message' => 'email already used'], 406);
        }
        $affectedRow = User::where('id', $request->id)
            ->update([
                'name' => $request->name, 'email' => $request->email, 'active' => $request->active, 'role' => $request->role
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    function resetPassword(Request $request)
    {
        $affectedRow = User::where('id', $request->id)
            ->update([
                'password' => Hash::make($request->newPassword),
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
