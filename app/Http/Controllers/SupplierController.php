<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroup;
use App\Models\M_SUP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    public function importFromAnotherCompany(Request $request)
    {
        $currentDBName = DB::connection($this->dedicatedConnection)->getDatabaseName();
        $RS = DB::connection($request->fromConnection)->table('M_SUP AS A')
            ->select('A.*')
            ->leftJoin($currentDBName . '.M_SUP AS B', 'A.MSUP_SUPCD', '=', 'B.MSUP_SUPCD')
            ->where('A.MSUP_BRANCH',  Auth::user()->branch)
            ->whereNull('B.MSUP_SUPCD');
        $RSTosave = json_decode(json_encode($RS->get()), true);
        if (!empty($RSTosave)) {
            M_SUP::on($this->dedicatedConnection)->insert($RSTosave);
            return ['message' => 'Done, ' . count($RSTosave) . ' imported'];
        } else {
            return ['message' => 'no new data'];
        }
    }

    public function index()
    {
        return view('master.supplier', [
            'companies' => CompanyGroup::select('*')->where('connection', '!=', $this->dedicatedConnection)->get(),            
            'CurrentCompanies' => CompanyGroup::select('*')->where('connection', $this->dedicatedConnection)->get()
        ]);
    }
    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MSUP_SUPCD' => 'required',
            'MSUP_SUPCD' => [
                Rule::unique($this->dedicatedConnection . '.M_SUP', 'MSUP_SUPCD')->where('MSUP_BRANCH', Auth::user()->branch)
            ],
            'MSUP_SUPNM' => 'required',
            'MSUP_CURCD' => 'required',
            'MSUP_ADDR1' => 'required',
            'MSUP_TELNO' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        M_SUP::on($this->dedicatedConnection)->create([
            'MSUP_SUPCD' => $request->MSUP_SUPCD,
            'MSUP_SUPNM' => $request->MSUP_SUPNM,
            'MSUP_CURCD' => $request->MSUP_CURCD,
            'MSUP_TAXREG' => $request->MSUP_TAXREG,
            'MSUP_ADDR1' => $request->MSUP_ADDR1,
            'MSUP_TELNO' => $request->MSUP_TELNO,
            'MSUP_CGCON' => $request->MSUP_CGCON,
            'created_by' => Auth::user()->nick_name,
            'MSUP_BRANCH' => Auth::user()->branch
        ]);
        return ['msg' => 'OK'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'MSUP_SUPCD',
            'MSUP_SUPNM',
            'MSUP_ADDR1',
        ];
        if ($request->companyGroupOnly) {
            if ($request->companyGroupOnly == 2) {
                $RS = M_SUP::on($this->dedicatedConnection)->select('*')
                    ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
                    ->whereNotNull("MSUP_CGCON")
                    ->where('MSUP_BRANCH', Auth::user()->branch)
                    ->get();
            } else {
                $RS = M_SUP::on($this->dedicatedConnection)->select('*')
                    ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
                    ->where('MSUP_BRANCH', Auth::user()->branch)
                    ->get();
            }
        } else {
            $RS = M_SUP::on($this->dedicatedConnection)->select('*')
                ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
                ->where('MSUP_BRANCH', Auth::user()->branch)
                ->get();
        }
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_SUP::on($this->dedicatedConnection)
            ->where('MSUP_SUPCD', base64_decode($request->id))
            ->where('MSUP_BRANCH', Auth::user()->branch)
            ->update([
                'MSUP_SUPNM' => $request->MSUP_SUPNM, 'MSUP_CURCD' => $request->MSUP_CURCD, 'MSUP_TAXREG' => $request->MSUP_TAXREG, 'MSUP_ADDR1' => $request->MSUP_ADDR1, 'MSUP_TELNO' => $request->MSUP_TELNO, 'MSUP_CGCON' => $request->MSUP_CGCON
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
