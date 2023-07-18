<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroup;
use App\Models\M_SUP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    public function index()
    {
        return view('master.supplier', ['companies' => CompanyGroup::select('*')->where('connection', '!=', $this->dedicatedConnection)->get()]);
    }
    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MSUP_SUPCD' => 'required',
            'MSUP_SUPCD' => [
                Rule::unique($this->dedicatedConnection . '.M_SUP', 'MSUP_SUPCD')
            ],
            'MSUP_SUPNM' => 'required',
            'MSUP_CURCD' => 'required',
            'MSUP_TAXREG' => 'required',
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
                    ->get();
            } else {
                $RS = M_SUP::on($this->dedicatedConnection)->select('*')
                    ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')->get();
            }
        } else {
            $RS = M_SUP::on($this->dedicatedConnection)->select('*')
                ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')->get();
        }
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_SUP::on($this->dedicatedConnection)->where('MSUP_SUPCD', base64_decode($request->id))
            ->update([
                'MSUP_SUPNM' => $request->MSUP_SUPNM, 'MSUP_CURCD' => $request->MSUP_CURCD, 'MSUP_TAXREG' => $request->MSUP_TAXREG, 'MSUP_ADDR1' => $request->MSUP_ADDR1, 'MSUP_TELNO' => $request->MSUP_TELNO, 'MSUP_CGCON' => $request->MSUP_CGCON
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
