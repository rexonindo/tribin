<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroup;
use App\Models\M_CUS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    public function index()
    {
        return view('master.customer', ['companies' => CompanyGroup::all()]);
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MCUS_CUSCD' => 'required',
            'MCUS_CUSCD' => [
                Rule::unique($this->dedicatedConnection . '.M_CUS', 'MCUS_CUSCD')
            ],
            'MCUS_CUSNM' => 'required',
            'MCUS_CURCD' => 'required',
            'MCUS_TAXREG' => 'required',
            'MCUS_ADDR1' => 'required',
            'MCUS_TELNO' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        M_CUS::on($this->dedicatedConnection)->create([
            'MCUS_CUSCD' => $request->MCUS_CUSCD,
            'MCUS_CUSNM' => $request->MCUS_CUSNM,
            'MCUS_CURCD' => $request->MCUS_CURCD,
            'MCUS_TAXREG' => $request->MCUS_TAXREG,
            'MCUS_ADDR1' => $request->MCUS_ADDR1,
            'MCUS_TELNO' => $request->MCUS_TELNO,
            'MCUS_CGCON' => $request->MCUS_CGCON,
            'created_by' => Auth::user()->nick_name,
        ]);
        return ['msg' => 'OK'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'MCUS_CUSCD',
            'MCUS_CUSNM',
            'MCUS_ADDR1',
        ];
        $RS = M_CUS::on($this->dedicatedConnection)->select('*')->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')->get();
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_CUS::on($this->dedicatedConnection)->where('MCUS_CUSCD', base64_decode($request->id))
            ->update([
                'MCUS_CUSNM' => $request->MCUS_CUSNM, 'MCUS_CURCD' => $request->MCUS_CURCD, 'MCUS_TAXREG' => $request->MCUS_TAXREG, 'MCUS_ADDR1' => $request->MCUS_ADDR1, 'MCUS_TELNO' => $request->MCUS_TELNO, 'MCUS_CGCON' => $request->MCUS_CGCON
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
