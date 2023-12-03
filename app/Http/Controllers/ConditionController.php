<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroup;
use App\Models\M_Condition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ConditionController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    public function index()
    {
        return view('master.condition', [
            'companies' => CompanyGroup::select('*')->where('connection', '!=', $this->dedicatedConnection)->get(),
            'CurrentCompanies' => CompanyGroup::select('*')->where('connection', $this->dedicatedConnection)->get()
        ]);
    }

    public function importFromAnotherCompany(Request $request)
    {
        $currentDBName = DB::connection($this->dedicatedConnection)->getDatabaseName();
        $RS = DB::connection($request->fromConnection)->table('M_CONDITIONS AS A')
            ->select('A.MCONDITION_DESCRIPTION', 'A.MCONDITION_ORDER_NUMBER', 'A.MCONDITION_BRANCH')
            ->leftJoin($currentDBName . '.M_CONDITIONS AS B', 'A.MCONDITION_DESCRIPTION', '=', 'B.MCONDITION_DESCRIPTION')
            ->where('A.MCONDITION_BRANCH',  Auth::user()->branch)
            ->whereNull('B.MCONDITION_DESCRIPTION');
        $RSTosave = json_decode(json_encode($RS->get()), true);
        if (!empty($RSTosave)) {
            M_Condition::on($this->dedicatedConnection)->insert($RSTosave);
            return ['message' => 'Done, ' . count($RSTosave) . ' imported'];
        } else {
            return ['message' => 'no new data'];
        }
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MCONDITION_DESCRIPTION' => 'required',
            'MCONDITION_DESCRIPTION' => [
                Rule::unique($this->dedicatedConnection . '.M_CONDITIONS', 'MCONDITION_DESCRIPTION')->where('MCONDITION_BRANCH', Auth::user()->branch)
            ],
            'MCONDITION_ORDER_NUMBER' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $creator = M_Condition::on($this->dedicatedConnection)->create([
            'MCONDITION_DESCRIPTION' => $request->MCONDITION_DESCRIPTION,
            'MCONDITION_ORDER_NUMBER' => $request->MCONDITION_ORDER_NUMBER,
            'MCONDITION_BRANCH' => Auth::user()->branch,
            'created_by' => Auth::user()->nick_name,
        ]);
        return ['msg' => 'OK', 'id' => $creator->id];
    }

    function search(Request $request)
    {
        $columnMap = [
            'MCONDITION_DESCRIPTION',
            'MCONDITION_ORDER_NUMBER',
        ];
        $RS = M_Condition::on($this->dedicatedConnection)->select('*')
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->where('MCONDITION_BRANCH', Auth::user()->branch)
            ->orderBy('MCONDITION_ORDER_NUMBER')
            ->get();
        return ['data' => $RS, Auth::user()->branch];
    }

    function update(Request $request)
    {
        $affectedRow = M_Condition::on($this->dedicatedConnection)
            ->where('id', base64_decode($request->id))
            ->where('MCONDITION_BRANCH', Auth::user()->branch)
            ->update([
                'MCONDITION_DESCRIPTION' => $request->MCONDITION_DESCRIPTION,
                'MCONDITION_ORDER_NUMBER' => $request->MCONDITION_ORDER_NUMBER,
                'updated_by' => Auth::user()->nick_name,
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    function delete(Request $request)
    {
        $affectedRow = M_Condition::on($this->dedicatedConnection)
            ->where('id', base64_decode($request->id))
            ->where('MCONDITION_BRANCH', Auth::user()->branch)
            ->delete();
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
