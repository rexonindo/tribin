<?php

namespace App\Http\Controllers;

use App\Models\C_CASHIER;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class CashierController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    function index()
    {
        return view('transaction.cashier');
    }

    function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CCASHIER_PRICE' => 'required|numeric',
            'CCASHIER_ISSUDT' => 'required|date',            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        C_CASHIER::on($this->dedicatedConnection)->create([
            'CCASHIER_BRANCH' => Auth::user()->branch,
            'CCASHIER_ITMCD' => '',
            'CCASHIER_LOCATION' => '',
            'CCASHIER_REMARK' => '',
            'CCASHIER_PRICE' => $request->CCASHIER_PRICE,
            'CCASHIER_ISSUDT' => $request->CCASHIER_ISSUDT,
            'CCASHIER_REFF_DOC' => $request->CCASHIER_ISSUDT,
            'CCASHIER_USER' => $request->CCASHIER_ISSUDT,
            'created_by' => Auth::user()->nick_name,
        ]);
        return ['msg' => 'OK'];
    }
}
