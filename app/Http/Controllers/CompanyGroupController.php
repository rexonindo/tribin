<?php

namespace App\Http\Controllers;

use App\Models\BranchPaymentAccount;
use App\Models\COMPANY_BRANCH;
use App\Models\CompanyGroup;
use App\Models\CompanyGroupAccess;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyGroupController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {
        $Configs = Config::get('database');
        $ConnectionList = [];
        foreach ($Configs['connections'] as $key => $value) {
            if (str_contains($key, 'jos')) {
                $ConnectionList[] = $key;
            }
        }
        return view('company_group', ['connections' => $ConnectionList, 'companies' => CompanyGroup::all(), 'roles' => Role::all()]);
    }

    static function getRoleBasedOnCompanyGroup($dedicatedConnection)
    {
        $rsCGRole = CompanyGroupAccess::select('role_name', 'description')
            ->leftJoin('roles', 'role_name', '=', 'name')
            ->where('nick_name', Auth::user()->nick_name)
            ->where('connection', $dedicatedConnection)
            ->whereNull('deleted_at')->first();
        return ['code' => $rsCGRole->role_name, 'name' => $rsCGRole->description];
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
            'alias_code' => 'required',
            'alias_group_code' => 'required',
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
            'alias_code' => $request->alias_code,
            'alias_group_code' => $request->alias_group_code,
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
                'alias_code' => $request->alias_code,
                'alias_group_code' => $request->alias_group_code,
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    function loadByNickName(Request $request)
    {
        $RS = CompanyGroupAccess::select(["COMPANY_GROUP_ACCESSES.id", "users.nick_name", "users.email", "COMPANY_GROUPS.name", "COMPANY_GROUP_ACCESSES.connection", "roles.description", "role_name"])
            ->leftJoin("users", "COMPANY_GROUP_ACCESSES.nick_name", "=", "users.nick_name")
            ->leftJoin("COMPANY_GROUPS", "COMPANY_GROUP_ACCESSES.connection", "=", "COMPANY_GROUPS.connection")
            ->leftJoin("roles", "roles.name", "=", "COMPANY_GROUP_ACCESSES.role_name")
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
            'role_name' => 'required',
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
            'role_name' => $request->role_name,
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

    function form()
    {
        if (isset($_COOKIE['CGID'])) {
            $this->dedicatedConnection = $_COOKIE['CGID'] === '-' ? '-' : Crypt::decryptString($_COOKIE['CGID']);
        } else {
            $this->dedicatedConnection = '-';
        }
        $SelectedCompany = COMPANY_BRANCH::on($this->dedicatedConnection)->select('*')
            ->where('connection', $this->dedicatedConnection)
            ->where('BRANCH', Auth::user()->branch)
            ->first();
        return view('master.company', ['SelectedCompany' => $SelectedCompany]);
    }

    function updateBranch(Request $request)
    {
        if (isset($_COOKIE['CGID'])) {
            $this->dedicatedConnection = $_COOKIE['CGID'] === '-' ? '-' : Crypt::decryptString($_COOKIE['CGID']);
        } else {
            $this->dedicatedConnection = '-';
        }
        if ($request->id === '-') {
            $ResponseDB = COMPANY_BRANCH::on($this->dedicatedConnection)->create([
                'created_by' => Auth::user()->nick_name,
                'BRANCH' => Auth::user()->branch,
                'connection' => $this->dedicatedConnection,
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'invoice_letter_id' => $request->invoice_letter_id,
                'quotation_letter_id' => $request->quotation_letter_id,
                'letter_head' => $request->letter_head,
            ]);
            $message = 'Saved';
            $id = $ResponseDB->id;
        } else {
            COMPANY_BRANCH::on($this->dedicatedConnection)->where('id', $request->id)
                ->update([
                    'updated_by' => Auth::user()->nick_name,
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'fax' => $request->fax,
                    'invoice_letter_id' => $request->invoice_letter_id,
                    'quotation_letter_id' => $request->quotation_letter_id,
                    'letter_head' => $request->letter_head,
                ]);
            $message = 'Updated';
            $id = $request->id;
        }
        return ['msg' => $message, 'id' => $id];
    }

    function savePaymentAccount(Request $request)
    {
        if (isset($_COOKIE['CGID'])) {
            $this->dedicatedConnection = $_COOKIE['CGID'] === '-' ? '-' : Crypt::decryptString($_COOKIE['CGID']);
        } else {
            $this->dedicatedConnection = '-';
        }

        $validator = Validator::make($request->all(), [
            'bank_name' => 'required',
            'bank_account_name' => 'required',
            'bank_account_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        BranchPaymentAccount::on($this->dedicatedConnection)->create([
            'connection' => $this->dedicatedConnection,
            'BRANCH' => Auth::user()->branch,
            'bank_name' => $request->bank_name,
            'bank_account_name' => $request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
            'created_by' => Auth::user()->nick_name,
        ]);

        return ['msg' => 'Saved successfully'];
    }

    function deletePaymentAccountCompanyBranch(Request $request)
    {
        if (isset($_COOKIE['CGID'])) {
            $this->dedicatedConnection = $_COOKIE['CGID'] === '-' ? '-' : Crypt::decryptString($_COOKIE['CGID']);
        } else {
            $this->dedicatedConnection = '-';
        }

        BranchPaymentAccount::on($this->dedicatedConnection)->where('id', $request->id)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => Auth::user()->nick_name,
            ]);
        return ['msg' => 'deleted'];
    }

    function getPaymentAccountCompanyBranch()
    {
        if (isset($_COOKIE['CGID'])) {
            $this->dedicatedConnection = $_COOKIE['CGID'] === '-' ? '-' : Crypt::decryptString($_COOKIE['CGID']);
        } else {
            $this->dedicatedConnection = '-';
        }
        $Accounts = BranchPaymentAccount::on($this->dedicatedConnection)
            ->where('BRANCH', Auth::user()->branch)
            ->whereNull('deleted_at')
            ->get();
        return ['data' => $Accounts];
    }
}
