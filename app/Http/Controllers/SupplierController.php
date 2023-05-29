<?php

namespace App\Http\Controllers;

use App\Models\M_SUP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        return view('master.supplier');
    }
    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MSUP_SUPCD' => 'required|unique:App\Models\M_SUP',
            'MSUP_SUPNM' => 'required',
            'MSUP_CURCD' => 'required',
            'MSUP_TAXREG' => 'required',
            'MSUP_ADDR1' => 'required',
            'MSUP_TELNO' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        M_SUP::create([
            'MSUP_SUPCD' => $request->MSUP_SUPCD,
            'MSUP_SUPNM' => $request->MSUP_SUPNM,
            'MSUP_CURCD' => $request->MSUP_CURCD,
            'MSUP_TAXREG' => $request->MSUP_TAXREG,
            'MSUP_ADDR1' => $request->MSUP_ADDR1,
            'MSUP_TELNO' => $request->MSUP_TELNO,
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
        $RS = M_SUP::select('*')->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')->get();
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_SUP::where('MSUP_SUPCD', base64_decode($request->id))
            ->update([
                'MSUP_SUPNM' => $request->MSUP_SUPNM
                ,'MSUP_CURCD' => $request->MSUP_CURCD                
                ,'MSUP_TAXREG' => $request->MSUP_TAXREG
                ,'MSUP_ADDR1' => $request->MSUP_ADDR1
                ,'MSUP_TELNO' => $request->MSUP_TELNO
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
