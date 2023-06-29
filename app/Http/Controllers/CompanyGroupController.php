<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroup;
use App\Models\CompanyGroupAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyGroupController extends Controller
{
    function index()
    {
        $Configs = Config::get('database');
        $ConnectionList = [];
        foreach ($Configs['connections'] as $key => $value) {
            if (str_contains($key, 'jos')) {
                $ConnectionList[] = $key;
            }
        }
        return view('company_group', ['connections' => $ConnectionList, 'companies' => CompanyGroup::all()]);
    }

    function search()
    {
        return ['data' => CompanyGroup::all()];
    }

    function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:App\Models\CompanyGroup',
            'address' => 'required|unique:App\Models\CompanyGroup',
            'phone' => 'required',
            'fax' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        CompanyGroup::create([
            'name' => $request->name,
            'address' => $request->address,
            'connection' => $request->connection,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ]);
        return ['msg' => 'OK'];
    }

    function update(Request $request)
    {
        $affectedRow = CompanyGroup::where('id', base64_decode($request->id))
            ->update([
                'name' => $request->name,
                'address' => $request->address,
                'connection' => $request->connection,
                'phone' => $request->phone,
                'fax' => $request->fax,
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    function loadByNickName(Request $request)
    {
        $RS = CompanyGroupAccess::select(["COMPANY_GROUP_ACCESSES.id", "users.nick_name", "users.email", "COMPANY_GROUPS.name", "COMPANY_GROUP_ACCESSES.connection"])
            ->leftJoin("users", "COMPANY_GROUP_ACCESSES.nick_name", "=", "users.nick_name")
            ->leftJoin("COMPANY_GROUPS", "COMPANY_GROUP_ACCESSES.connection", "=", "COMPANY_GROUPS.connection")
            ->where('COMPANY_GROUP_ACCESSES.nick_name', base64_decode($request->id))
            ->whereNull('COMPANY_GROUP_ACCESSES.deleted_at')
            ->get();
        foreach ($RS as &$r) {
            $r->connection = Crypt::encryptString($r->connection);
        }
        unset($r);
        return ['data' => $RS];
    }

    function saveAccess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nick_name' => 'required',
            'connection' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        if (
            DB::table('COMPANY_GROUP_ACCESSES')
            ->where('nick_name', $request->nick_name)
            ->where('connection', $request->connection)
            ->whereNull('deleted_at')
            ->count() > 0
        ) {
            return response()->json(['message' => 'Already registered'], 406);
        }

        CompanyGroupAccess::create([
            'nick_name' => $request->nick_name,
            'connection' => $request->connection,
            'created_by' => Auth::user()->nick_name,
        ]);
        return ['msg' => 'OK'];
    }

    function deleteAccess(Request $request)
    {
        $affectedRow = CompanyGroupAccess::where('id', $request->id)->whereNull('deleted_at')
            ->update(['deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::user()->nick_name]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
