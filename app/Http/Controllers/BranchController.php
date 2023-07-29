<?php

namespace App\Http\Controllers;

use App\Models\M_BRANCH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    function index()
    {
        return view('master.branch');
    }

    function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MBRANCH_CD' => 'required',
            'MBRANCH_CD' => [
                Rule::unique($this->dedicatedConnection . '.M_BRANCH', 'MBRANCH_CD')
            ],
            'MBRANCH_NM' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        M_BRANCH::on($this->dedicatedConnection)->create([
            'MBRANCH_CD' => $request->MBRANCH_CD,
            'MBRANCH_NM' => $request->MBRANCH_NM,
            'created_by' => Auth::user()->nick_name,
        ]);
        return ['msg' => 'OK'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'MBRANCH_CD',
            'MBRANCH_NM',
        ];
        $RS = M_BRANCH::on($this->dedicatedConnection)->select('*')->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')->get();
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_BRANCH::on($this->dedicatedConnection)->where('MBRANCH_CD', base64_decode($request->id))
            ->update([
                'MBRANCH_NM' => $request->MBRANCH_NM
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
