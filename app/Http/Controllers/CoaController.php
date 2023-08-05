<?php

namespace App\Http\Controllers;

use App\Models\M_COA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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
        return view('master.coa');
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
