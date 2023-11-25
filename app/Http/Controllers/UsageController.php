<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroup;
use App\Models\M_USAGE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsageController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    function index()
    {
        return view('master.usage', [
            'companies' => CompanyGroup::select('*')->where('connection', '!=', $this->dedicatedConnection)->get(),
            'CurrentCompanies' => CompanyGroup::select('*')->where('connection', $this->dedicatedConnection)->get()
        ]);
    }

    public function importFromAnotherCompany(Request $request)
    {
        $currentDBName = DB::connection($this->dedicatedConnection)->getDatabaseName();
        $RS = DB::connection($request->fromConnection)->table('M_USAGE AS A')
            ->select('A.*')
            ->leftJoin($currentDBName . '.M_USAGE AS B', 'A.MUSAGE_CD', '=', 'B.MUSAGE_CD')
            ->where('A.MUSAGE_BRANCH',  Auth::user()->branch)
            ->whereNull('B.MUSAGE_CD');

        $RSTosave = json_decode(json_encode($RS->get()), true);

        if (!empty($RSTosave)) {
            M_USAGE::on($this->dedicatedConnection)->insert($RSTosave);
            return ['message' => 'Done, ' . count($RSTosave) . ' imported'];
        } else {
            return ['message' => 'no new data'];
        }
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MUSAGE_CD' => 'required',
            'MUSAGE_CD' => [
                Rule::unique($this->dedicatedConnection . '.M_USAGE', 'MUSAGE_CD')->where('MUSAGE_BRANCH', Auth::user()->branch)
            ],
            'MUSAGE_ALIAS' => 'required',
            'MUSAGE_DESCRIPTION' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        M_USAGE::on($this->dedicatedConnection)->create([
            'created_by' => Auth::user()->nick_name,
            'MUSAGE_CD' => $request->MUSAGE_CD,
            'MUSAGE_ALIAS' => $request->MUSAGE_ALIAS,
            'MUSAGE_DESCRIPTION' => $request->MUSAGE_DESCRIPTION,
            'MUSAGE_BRANCH' => Auth::user()->branch
        ]);

        return ['msg' => 'OK'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'MUSAGE_CD',
            'MUSAGE_ALIAS',
        ];
        $RS = M_USAGE::on($this->dedicatedConnection)->select('*')
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->where('MUSAGE_BRANCH', Auth::user()->branch)
            ->get();
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_USAGE::on($this->dedicatedConnection)
            ->where('MUSAGE_CD', base64_decode($request->id))
            ->where('MUSAGE_BRANCH', Auth::user()->branch)
            ->update([
                'MUSAGE_ALIAS' => $request->MUSAGE_ALIAS,
                'MUSAGE_DESCRIPTION' => $request->MUSAGE_DESCRIPTION
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
