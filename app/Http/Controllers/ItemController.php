<?php

namespace App\Http\Controllers;

use App\Models\M_ITM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ItemController extends Controller
{
    public function index()
    {
        return view('master.item');
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MITM_ITMCD' => 'required|unique:App\Models\M_ITM',
            'MITM_ITMNM' => 'required',
            'MITM_STKUOM' => 'required',
            'MITM_ITMTYPE' => 'required',
            'MITM_BRAND' => 'required',
            'MITM_SPEC' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        M_ITM::create([
            'MITM_ITMCD' => $request->MITM_ITMCD,
            'MITM_ITMNM' => $request->MITM_ITMNM,
            'MITM_STKUOM' => $request->MITM_STKUOM,
            'MITM_ITMTYPE' => $request->MITM_ITMTYPE,
            'MITM_BRAND' => $request->MITM_BRAND,
            'MITM_MODEL' => $request->MITM_MODEL,
            'MITM_SPEC' => $request->MITM_SPEC,
        ]);
        return ['msg' => 'OK'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'MITM_ITMCD',
            'MITM_ITMNM',
            'MITM_SPEC',
        ];
        $RS = M_ITM::select('*')->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')->get();
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_ITM::where('MITM_ITMCD', base64_decode($request->id))
            ->update([
                'MITM_ITMNM' => $request->MITM_ITMNM
                ,'MITM_STKUOM' => $request->MITM_STKUOM
                ,'MITM_ITMTYPE' => $request->MITM_ITMTYPE
                ,'MITM_BRAND' => $request->MITM_BRAND
                ,'MITM_MODEL' => $request->MITM_MODEL
                ,'MITM_SPEC' => $request->MITM_SPEC
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
