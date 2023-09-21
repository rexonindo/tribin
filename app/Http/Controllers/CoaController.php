<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroup;
use App\Models\M_COA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CoaController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    public function index()
    {
        return view('master.coa', [
            'companies' => CompanyGroup::select('*')->where('connection', '!=', $this->dedicatedConnection)->get(),
            'CurrentCompanies' => CompanyGroup::select('*')->where('connection', $this->dedicatedConnection)->get()
        ]);
    }

    public function importFromAnotherCompany(Request $request)
    {
        $currentDBName = DB::connection($this->dedicatedConnection)->getDatabaseName();
        $RS = DB::connection($request->fromConnection)->table('M_COA AS A')
            ->select('A.*')
            ->leftJoin($currentDBName . '.M_COA AS B', 'A.MCOA_COACD', '=', 'B.MCOA_COACD')
            ->where('A.MCOA_BRANCH',  Auth::user()->branch)
            ->whereNull('B.MCOA_COACD');
        $RSTosave = json_decode(json_encode($RS->get()), true);
        if (!empty($RSTosave)) {
            M_COA::on($this->dedicatedConnection)->insert($RSTosave);
            return ['message' => 'Done, ' . count($RSTosave) . ' imported'];
        } else {
            return ['message' => 'no new data'];
        }
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MCOA_COACD' => 'required',
            'MCOA_COACD' => [
                Rule::unique($this->dedicatedConnection . '.M_COA', 'MCOA_COACD')->where('MCOA_BRANCH', Auth::user()->branch)
            ],
            'MCOA_COANM' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        M_COA::on($this->dedicatedConnection)->create([
            'MCOA_COACD' => $request->MCOA_COACD,
            'MCOA_COANM' => $request->MCOA_COANM,
            'MCOA_BRANCH' => Auth::user()->branch
        ]);
        return ['msg' => 'OK'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'MCOA_COACD',
            'MCOA_COANM',
        ];
        $RS = M_COA::on($this->dedicatedConnection)->select('*')
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->where('MCOA_BRANCH', Auth::user()->branch)
            ->get();
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_COA::on($this->dedicatedConnection)
            ->where('MCOA_COACD', base64_decode($request->id))
            ->where('MCOA_BRANCH', Auth::user()->branch)
            ->update([
                'MCOA_COANM' => $request->MCOA_COANM
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
