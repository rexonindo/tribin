<?php

namespace App\Http\Controllers;

use App\Models\T_SLODETA;
use App\Models\T_SLOHEAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ReceiveOrderController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');        
    }
    public function index()
    {
        return view('transaction.receive_order');
    }
    public function save(Request $request)
    {
        $monthOfRoma = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

        # data quotation header
        $validator = Validator::make($request->all(), [
            'TSLO_CUSCD' => 'required',
            'TSLO_ATTN' => 'required',
            'TSLO_QUOCD' => 'required',
            'TSLO_POCD' => 'required',
            'TSLO_ISSUDT' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $LastLine = DB::table('T_SLOHEAD')
            ->whereMonth('created_at', '=', date('m'))
            ->whereYear('created_at', '=', date('Y'))
            ->max('TSLO_LINE');

        $quotationHeader = [];
        $newDocumentCode = '';
        if (!$LastLine) {
            $newDocumentCode = '001/PT/SLO/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
        } else {
            $LastLine++;
            $newDocumentCode = substr('00' . $LastLine, -3) . '/PT/SLO/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
        }
        $quotationHeader = [
            'TSLO_SLOCD' => $newDocumentCode,
            'TSLO_CUSCD' => $request->TSLO_CUSCD,
            'TSLO_LINE' => 1,
            'TSLO_ATTN' => $request->TSLO_ATTN,
            'TSLO_QUOCD' => $request->TSLO_QUOCD,
            'TSLO_POCD' => $request->TSLO_POCD,
            'TSLO_ISSUDT' => $request->TSLO_ISSUDT,
            'created_by' => Auth::user()->nick_name,
        ];
        T_SLOHEAD::create($quotationHeader);

        # data quotation detail item
        $validator = Validator::make($request->all(), [
            'TSLODETA_ITMCD' => 'required|array',
            'TSLODETA_USAGE' => 'required|array',
            'TSLODETA_USAGE.*' => 'required|numeric',
            'TSLODETA_PRC' => 'required|array',
            'TSLODETA_PRC.*' => 'required|numeric',
            'TSLODETA_MOBDEMOB' => 'required|array',
            'TSLODETA_MOBDEMOB.*' => 'required|numeric',
            'TSLODETA_OPRPRC' => 'required|array',
            'TSLODETA_OPRPRC.*' => 'required|numeric',
            'TSLODETA_MOBDEMOB' => 'required|array',
            'TSLODETA_MOBDEMOB.*' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }
        $countDetail = count($request->TSLODETA_ITMCD);
        $quotationDetail = [];
        for ($i = 0; $i < $countDetail; $i++) {
            $quotationDetail[] = [
                'TSLODETA_SLOCD' => $newDocumentCode,
                'TSLODETA_ITMCD' => $request->TSLODETA_ITMCD[$i],
                'TSLODETA_ITMQT' => $request->TSLODETA_ITMQT[$i],
                'TSLODETA_USAGE' => $request->TSLODETA_USAGE[$i],
                'TSLODETA_PRC' => $request->TSLODETA_PRC[$i],
                'TSLODETA_OPRPRC' => $request->TSLODETA_OPRPRC[$i],
                'TSLODETA_MOBDEMOB' => $request->TSLODETA_MOBDEMOB[$i],
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        if (!empty($quotationDetail)) {
            T_SLODETA::insert($quotationDetail);
        }
        
        return [
            'msg' => 'OK', 'doc' => $newDocumentCode, '$RSLast' => $LastLine, 'quotationHeader' => $quotationHeader, 'quotationDetail' => $quotationDetail
        ];
    }

    function search(Request $request)
    {
        $columnMap = [
            'TSLO_SLOCD',
            'MCUS_CUSNM',
            'TSLO_POCD',
        ];

        $RS = T_SLOHEAD::select(["TSLO_SLOCD", "TSLO_CUSCD", "MCUS_CUSNM", "TSLO_ISSUDT", "TSLO_QUOCD", "TSLO_POCD", "TSLO_ATTN"])
            ->leftJoin("M_CUS", "TSLO_CUSCD", "=", "MCUS_CUSCD")
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->get();
        return ['data' => $RS];
    }

    function loadById(Request $request)
    {
        $RS = T_SLODETA::select(["id", "TSLODETA_ITMCD", "MITM_ITMNM", "TSLODETA_USAGE", "TSLODETA_PRC", "TSLODETA_OPRPRC", "TSLODETA_MOBDEMOB"])
            ->leftJoin("M_ITM", "TSLODETA_ITMCD", "=", "MITM_ITMCD")
            ->where('TSLODETA_SLOCD', base64_decode($request->id))
            ->whereNull('deleted_at')->get();        
        return ['dataItem' => $RS];
    }

    function deleteItemById(Request $request)
    {
        $affectedRow = T_SLODETA::where('id', $request->id)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::user()->nick_name
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'could not be deleted', 'affectedRow' => $affectedRow];
    }

}
