<?php

namespace App\Http\Controllers;

use App\Models\M_COA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CoaController extends Controller
{
    public function index()
    {
        return view('master.coa');
    }
    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MCOA_COACD' => 'required|unique:App\Models\M_COA',
            'MCOA_COANM' => 'required',           
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        M_COA::create([
            'MCOA_COACD' => $request->MCOA_COACD,
            'MCOA_COANM' => $request->MCOA_COANM,           
        ]);
        return ['msg' => 'OK'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'MCOA_COACD',
            'MCOA_COANM',            
        ];
        $RS = M_COA::select('*')->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')->get();
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_COA::where('MCOA_COACD', base64_decode($request->id))
            ->update([
                'MCOA_COANM' => $request->MCOA_COANM                
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
