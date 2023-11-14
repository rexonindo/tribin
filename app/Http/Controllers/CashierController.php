<?php

namespace App\Http\Controllers;

use App\Models\C_CASHIER;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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
            'CCASHIER_REMARK' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        C_CASHIER::on($this->dedicatedConnection)->create([
            'CCASHIER_BRANCH' => Auth::user()->branch,
            'CCASHIER_ITMCD' => '',
            'CCASHIER_LOCATION' => '',
            'CCASHIER_REMARK' => $request->CCASHIER_REMARK,
            'CCASHIER_PRICE' => $request->CCASHIER_PRICE,
            'CCASHIER_ISSUDT' => $request->CCASHIER_ISSUDT,
            'CCASHIER_REFF_DOC' => $request->CCASHIER_REFF_DOC,
            'CCASHIER_USER' => $request->CCASHIER_USER,
            'created_by' => Auth::user()->nick_name,
        ]);
        return ['msg' => 'OK'];
    }

    function search(Request $request)
    {
        $PreviousBalance = C_CASHIER::on($this->dedicatedConnection)
            ->select(
                DB::raw('NULL CCASHIER_ISSUDT'),
                DB::raw('NULL CCASHIER_REFF_DOC'),
                DB::raw('NULL CCASHIER_USER'),
                DB::raw('SUM(CASE WHEN CCASHIER_PRICE > 0 THEN CCASHIER_PRICE ELSE 0 END ) AS INVALUE'),
                DB::raw('SUM(CASE WHEN CCASHIER_PRICE < 0 THEN CCASHIER_PRICE ELSE 0 END ) AS OUTVALUE'),
                DB::raw("IFNULL(SUM(CCASHIER_PRICE),0) PREVIOUS_BALANCE")
            )
            ->where('CCASHIER_ISSUDT', '<', $request->DATE_FROM)
            ->get();
        $PeriodTrans = C_CASHIER::on($this->dedicatedConnection)
            ->select(
                DB::raw('CCASHIER_ISSUDT'),
                DB::raw('CCASHIER_REFF_DOC'),
                DB::raw('CCASHIER_USER'),
                DB::raw('ABS(SUM(CASE WHEN CCASHIER_PRICE > 0 THEN CCASHIER_PRICE ELSE 0 END )) AS INVALUE'),
                DB::raw('ABS(SUM(CASE WHEN CCASHIER_PRICE < 0 THEN CCASHIER_PRICE ELSE 0 END )) AS OUTVALUE'),
                DB::raw("0 PREVIOUS_BALANCE")
            )
            ->where('CCASHIER_ISSUDT', '>', $request->DATE_FROM)
            ->where('CCASHIER_ISSUDT', '<=', $request->DATE_TO)
            ->groupBy('CCASHIER_ISSUDT', 'CCASHIER_REFF_DOC', 'CCASHIER_USER')
            ->orderBy('CCASHIER_ISSUDT')
            ->get();
        $PeriodTrans = json_decode(json_encode($PeriodTrans), true);
        foreach ($PreviousBalance as $r) {
            $currentBalance = $r->PREVIOUS_BALANCE;
            foreach ($PeriodTrans as &$n) {
                $currentBalance = $currentBalance - $n['OUTVALUE'] + $n['INVALUE'];
                $n['PREVIOUS_BALANCE'] = $currentBalance;
            }
        }
        return ['data' => $PreviousBalance, 'dataTx' => $PeriodTrans];
    }

    function searchHeader(Request $request)
    {
        $columnMap = [
            'CCASHIER_REFF_DOC',
            'CCASHIER_USER',
        ];
        $Data = C_CASHIER::on($this->dedicatedConnection)
            ->select('id', 'CCASHIER_ISSUDT', 'CCASHIER_REFF_DOC', 'CCASHIER_USER', 'CCASHIER_PRICE')
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->orderBy('CCASHIER_ISSUDT')
            ->orderBy('created_at')
            ->get();
        return ['data' => $Data];
    }
}
