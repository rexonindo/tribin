<?php

namespace App\Http\Controllers;

use App\Models\C_SPK;
use App\Models\CompanyGroup;
use App\Models\M_DISTANCE_PRICE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DistancePriceController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    public function index()
    {
        return view('master.distance_price', [
            'companies' => CompanyGroup::select('*')->where('connection', '!=', $this->dedicatedConnection)->get(),
            'CurrentCompanies' => CompanyGroup::select('*')->where('connection', $this->dedicatedConnection)->get()
        ]);
    }

    function search(Request $request)
    {
        $columnMap = [
            'RANGE1',
        ];
        $RS = M_DISTANCE_PRICE::on($this->dedicatedConnection)->select('*')
            ->where($columnMap[$request->searchBy], '>=',  $request->searchValue ? $request->searchValue : 0)
            ->where('BRANCH', Auth::user()->branch)
            ->orderBy('RANGE1', 'ASC')
            ->get();
        return ['data' => $RS];
    }

    public function importFromAnotherCompany(Request $request)
    {
        $currentDBName = DB::connection($this->dedicatedConnection)->getDatabaseName();
        $RS = DB::connection($request->fromConnection)->table('M_DISTANCE_PRICE AS A')
            ->select('A.*')
            ->leftJoin($currentDBName . '.M_DISTANCE_PRICE AS B', 'A.RANGE1', '=', 'B.RANGE1')
            ->where('A.BRANCH',  Auth::user()->branch)
            ->whereNull('B.RANGE1');
        $RSTosave = json_decode(json_encode($RS->get()), true);
        if (!empty($RSTosave)) {
            M_DISTANCE_PRICE::on($this->dedicatedConnection)->insert($RSTosave);
            return ['message' => 'Done, ' . count($RSTosave) . ' imported'];
        } else {
            return ['message' => 'no new data'];
        }
    }

    function update(Request $request)
    {
        $affectedRow = M_DISTANCE_PRICE::on($this->dedicatedConnection)
            ->where('RANGE1', base64_decode($request->id))
            ->where('BRANCH', Auth::user()->branch)
            ->update([
                'PRICE_WHEEL_4_AND_6' => $request->PRICE_WHEEL_4_AND_6,
                'PRICE_WHEEL_10' => $request->PRICE_WHEEL_10,
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'RANGE1' => 'required|numeric',
            'RANGE1' => [
                Rule::unique($this->dedicatedConnection . '.M_DISTANCE_PRICE', 'RANGE1')->where('BRANCH', Auth::user()->branch)
            ],
            'RANGE2' => 'required|numeric',
            'PRICE_WHEEL_4_AND_6' => 'required|numeric',
            'PRICE_WHEEL_10' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        M_DISTANCE_PRICE::on($this->dedicatedConnection)->create([
            'created_by' => Auth::user()->nick_name,
            'BRANCH' => Auth::user()->branch,
            'RANGE1' => $request->RANGE1,
            'RANGE2' => $request->RANGE2,
            'PRICE_WHEEL_4_AND_6' => $request->PRICE_WHEEL_4_AND_6,
            'PRICE_WHEEL_10' => $request->PRICE_WHEEL_10,
        ]);
        return ['msg' => 'OK'];
    }
}
