<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroup;
use App\Models\M_UOM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MeasurementController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    public function index()
    {
        return view('master.uom', [
            'companies' => CompanyGroup::select('*')->where('connection', '!=', $this->dedicatedConnection)->get(),
            'CurrentCompanies' => CompanyGroup::select('*')->where('connection', $this->dedicatedConnection)->get()
        ]);
    }

    public function importFromAnotherCompany(Request $request)
    {
        $currentDBName = DB::connection($this->dedicatedConnection)->getDatabaseName();
        $RS = DB::connection($request->fromConnection)->table('M_UOM AS A')
            ->select('A.*')
            ->leftJoin($currentDBName . '.M_UOM AS B', 'A.MUOM_UOMCD', '=', 'B.MUOM_UOMCD')
            ->where('A.MUOM_BRANCH',  Auth::user()->branch)
            ->whereNull('B.MUOM_UOMCD');
        $RSTosave = json_decode(json_encode($RS->get()), true);

        if (!empty($RSTosave)) {
            M_UOM::on($this->dedicatedConnection)->insert($RSTosave);
            return ['message' => 'Done, ' . count($RSTosave) . ' imported'];
        } else {
            return ['message' => 'no new data'];
        }
    }

    function search(Request $request)
    {
        $columnMap = [
            'MUOM_UOMCD',
            'MUOM_UOMNM',
        ];
        $RS = M_UOM::on($this->dedicatedConnection)->select('*')
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->where('MUOM_BRANCH', Auth::user()->branch)
            ->get();
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_UOM::on($this->dedicatedConnection)
            ->where('MUOM_UOMCD', base64_decode($request->id))
            ->where('MUOM_BRANCH', Auth::user()->branch)
            ->update([
                'MUOM_UOMNM' => $request->MUOM_UOMNM
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MUOM_UOMCD' => 'required',
            'MUOM_UOMCD' => [
                Rule::unique($this->dedicatedConnection . '.M_UOM', 'MUOM_UOMCD')->where('MUOM_BRANCH', Auth::user()->branch)
            ],
            'MUOM_UOMNM' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        M_UOM::on($this->dedicatedConnection)->create([
            'MUOM_UOMCD' => $request->MUOM_UOMCD,
            'MUOM_UOMNM' => $request->MUOM_UOMNM,
            'MUOM_BRANCH' => Auth::user()->branch
        ]);
        return ['msg' => 'OK'];
    }
}
