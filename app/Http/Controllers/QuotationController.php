<?php

namespace App\Http\Controllers;

use App\Models\T_QUOCOND;
use App\Models\T_QUODETA;
use App\Models\T_QUOHEAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        return view('transaction.quotation');
    }

    public function save(Request $request)
    {
        $monthOfRoma = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

        # data quotation header
        $validator = Validator::make($request->all(), [
            'TQUO_CUSCD' => 'required',
            'TQUO_ATTN' => 'required',
            'TQUO_SBJCT' => 'required',
            'TQUO_ISSUDT' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $LastLine = DB::table('T_QUOHEAD')
            ->whereMonth('created_at', '=', date('m'))
            ->whereYear('created_at', '=', date('Y'))
            ->max('TQUO_LINE');

        $quotationHeader = [];
        $newQuotationCode = '';
        if (!$LastLine) {
            $newQuotationCode = '001/PT/PNW/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
        } else {
            $LastLine++;
            $newQuotationCode = substr('00' . $LastLine, -3) . '/PT/PNW/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
        }
        $quotationHeader = [
            'TQUO_QUOCD' => $newQuotationCode,
            'TQUO_CUSCD' => $request->TQUO_CUSCD,
            'TQUO_LINE' => 1,
            'TQUO_ATTN' => $request->TQUO_ATTN,
            'TQUO_SBJCT' => $request->TQUO_SBJCT,
            'TQUO_ISSUDT' => $request->TQUO_ISSUDT,
            'created_by' => Auth::user()->nick_name,
        ];
        T_QUOHEAD::create($quotationHeader);

        # data quotation detail item
        $validator = Validator::make($request->all(), [
            'TQUODETA_ITMCD' => 'required|array',
            'TQUODETA_USAGE' => 'required|array',
            'TQUODETA_USAGE.*' => 'required|numeric',
            'TQUODETA_PRC' => 'required|array',
            'TQUODETA_PRC.*' => 'required|numeric',
            'TQUODETA_MOBDEMOB' => 'required|array',
            'TQUODETA_MOBDEMOB.*' => 'required|numeric',
            'TQUODETA_OPRPRC' => 'required|array',
            'TQUODETA_OPRPRC.*' => 'required|numeric',
            'TQUODETA_MOBDEMOB' => 'required|array',
            'TQUODETA_MOBDEMOB.*' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }
        $countDetail = count($request->TQUODETA_ITMCD);
        $quotationDetail = [];
        for ($i = 0; $i < $countDetail; $i++) {
            $quotationDetail[] = [
                'TQUODETA_QUOCD' => $newQuotationCode,
                'TQUODETA_ITMCD' => $request->TQUODETA_ITMCD[$i],
                'TQUODETA_ITMQT' => $request->TQUODETA_ITMQT[$i],
                'TQUODETA_USAGE' => $request->TQUODETA_USAGE[$i],
                'TQUODETA_PRC' => $request->TQUODETA_PRC[$i],
                'TQUODETA_OPRPRC' => $request->TQUODETA_OPRPRC[$i],
                'TQUODETA_MOBDEMOB' => $request->TQUODETA_MOBDEMOB[$i],
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        if (!empty($quotationDetail)) {
            T_QUODETA::insert($quotationDetail);
        }

        # data quotation condition
        $validator = Validator::make($request->all(), [
            'TQUOCOND_CONDI' => 'required|array',
            'TQUOCOND_CONDI.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }
        $countDetailCondition = count($request->TQUOCOND_CONDI);
        $quotationCondition = [];
        for ($i = 0; $i < $countDetailCondition; $i++) {
            $quotationCondition[] = [
                'TQUOCOND_QUOCD' => $newQuotationCode,
                'TQUOCOND_CONDI' => $request->TQUOCOND_CONDI[$i],
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        if (!empty($quotationCondition)) {
            T_QUOCOND::insert($quotationCondition);
        }
        return [
            'msg' => 'OK', 'doc' => $newQuotationCode, '$RSLast' => $LastLine, 'quotationHeader' => $quotationHeader, 'quotationDetail' => $quotationDetail
        ];
    }

    function search(Request $request)
    {
        $columnMap = [
            'TQUO_QUOCD',
            'MCUS_CUSNM',
        ];
        $RS = T_QUOHEAD::select(["TQUO_QUOCD", "TQUO_CUSCD", "MCUS_CUSNM", "TQUO_ISSUDT", "TQUO_SBJCT", "TQUO_ATTN"])
            ->leftJoin("M_CUS", "TQUO_CUSCD", "=", "MCUS_CUSCD")
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')->get();
        return ['data' => $RS];
    }

    function loadById(Request $request)
    {
        $RS = T_QUODETA::select(["id", "TQUODETA_ITMCD", "MITM_ITMNM", "TQUODETA_USAGE", "TQUODETA_PRC", "TQUODETA_OPRPRC", "TQUODETA_MOBDEMOB"])
            ->leftJoin("M_ITM", "TQUODETA_ITMCD", "=", "MITM_ITMCD")
            ->where('TQUODETA_QUOCD', base64_decode($request->id) )->get();
        $RS1 = T_QUOCOND::select(["id", "TQUOCOND_CONDI"])
            ->where('TQUOCOND_QUOCD', base64_decode($request->id))->get();
        return ['dataItem' => $RS, 'dataCondition' => $RS1];
    }
}
