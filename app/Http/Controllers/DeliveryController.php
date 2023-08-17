<?php

namespace App\Http\Controllers;

use App\Models\T_DLVORDDETA;
use App\Models\T_DLVORDHEAD;
use App\Models\T_SLODETA;
use App\Models\T_SLOHEAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    protected $dedicatedConnection;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    function index()
    {
        return view('transaction.delivery');
    }

    function outstandingWarehouse(Request $request)
    {
        $columnMap = [
            'TSLO_SLOCD',
            'MCUS_CUSNM',
            'TSLO_POCD',
        ];

        $RSDelivery = T_DLVORDDETA::on($this->dedicatedConnection)->selectRaw('TDLVORDDETA_SLOCD,TDLVORDDETA_BRANCH,TDLVORDDETA_ITMCD, sum(TDLVORDDETA_ITMQT) TTLDLVQT')
            ->whereNull('deleted_at')
            ->where('TDLVORDDETA_BRANCH', Auth::user()->branch)
            ->groupBy('TDLVORDDETA_SLOCD', 'TDLVORDDETA_BRANCH', 'TDLVORDDETA_ITMCD');
        $SalesDetail = T_SLODETA::on($this->dedicatedConnection)->selectRaw('TSLODETA_SLOCD,TSLODETA_BRANCH,TSLODETA_ITMCD,sum(TSLODETA_ITMQT) SALESQT')
            ->whereNull('deleted_at')
            ->where('TSLODETA_BRANCH', Auth::user()->branch)
            ->groupBy('TSLODETA_SLOCD', 'TSLODETA_BRANCH', 'TSLODETA_ITMCD');

        $RS = T_SLOHEAD::on($this->dedicatedConnection)->select([
            "TSLO_SLOCD", "TSLO_CUSCD", "MCUS_CUSNM", "TSLO_PLAN_DLVDT",
            DB::raw("SUM(SALESQT) SALESQT"), DB::raw("IFNULL(SUM(TTLDLVQT),0) AS TTLDLVQT")
        ])
            ->leftJoin("M_CUS", function ($join) {
                $join->on("TSLO_CUSCD", "=", "MCUS_CUSCD")
                    ->on('TSLO_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->joinSub($SalesDetail, 'V1', function ($join) {
                $join->on('TSLO_SLOCD', '=', 'TSLODETA_SLOCD')->on('TSLO_BRANCH', '=', 'TSLODETA_BRANCH');
            })
            ->leftJoinSub($RSDelivery, 'V2', function ($join) {
                $join->on('TSLODETA_SLOCD', '=', 'TDLVORDDETA_SLOCD')->on('TSLODETA_BRANCH', '=', 'TDLVORDDETA_BRANCH')
                    ->on('TSLODETA_ITMCD', '=', 'TDLVORDDETA_ITMCD');
            })
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->where('TSLO_BRANCH', Auth::user()->branch)
            ->whereRaw("SALESQT>IFNULL(TTLDLVQT,0)")
            ->groupBy("TSLO_SLOCD", "TSLO_CUSCD", "MCUS_CUSNM", "TSLO_PLAN_DLVDT");
        return ['data' => $RS->get()];
    }

    function outstandingWarehousePerDocument(Request $request)
    {
        $RSDelivery = T_DLVORDDETA::on($this->dedicatedConnection)->selectRaw('TDLVORDDETA_SLOCD,TDLVORDDETA_BRANCH,TDLVORDDETA_ITMCD, sum(TDLVORDDETA_ITMQT) TTLDLVQT')
            ->whereNull('deleted_at')
            ->where('TDLVORDDETA_BRANCH', Auth::user()->branch)
            ->groupBy('TDLVORDDETA_SLOCD', 'TDLVORDDETA_BRANCH', 'TDLVORDDETA_ITMCD');
        $SalesDetail = T_SLODETA::on($this->dedicatedConnection)->selectRaw('TSLODETA_SLOCD,TSLODETA_BRANCH,TSLODETA_ITMCD,sum(TSLODETA_ITMQT) SALESQT')
            ->whereNull('deleted_at')
            ->where('TSLODETA_BRANCH', Auth::user()->branch)
            ->groupBy('TSLODETA_SLOCD', 'TSLODETA_BRANCH', 'TSLODETA_ITMCD');

        $RS = T_SLOHEAD::on($this->dedicatedConnection)->select([
            "TSLO_SLOCD", "TSLO_CUSCD", "MCUS_CUSNM", "TSLO_PLAN_DLVDT", "TSLODETA_ITMCD", "MITM_ITMNM",
            DB::raw("SUM(SALESQT)-IFNULL(SUM(TTLDLVQT),0) BALQT")
        ])
            ->leftJoin("M_CUS", function ($join) {
                $join->on("TSLO_CUSCD", "=", "MCUS_CUSCD")
                    ->on('TSLO_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->joinSub($SalesDetail, 'V1', function ($join) {
                $join->on('TSLO_SLOCD', '=', 'TSLODETA_SLOCD')->on('TSLO_BRANCH', '=', 'TSLODETA_BRANCH');
            })
            ->leftJoinSub($RSDelivery, 'V2', function ($join) {
                $join->on('TSLODETA_SLOCD', '=', 'TDLVORDDETA_SLOCD')->on('TSLODETA_BRANCH', '=', 'TDLVORDDETA_BRANCH')
                    ->on('TSLODETA_ITMCD', '=', 'TDLVORDDETA_ITMCD');
            })
            ->leftJoin("M_ITM", function ($join) {
                $join->on('TSLODETA_ITMCD', '=', 'MITM_ITMCD')->on('TSLODETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->where('TSLO_SLOCD', base64_decode($request->id))
            ->where('TSLO_BRANCH', Auth::user()->branch)
            ->whereRaw("SALESQT>IFNULL(TTLDLVQT,0)")
            ->groupBy("TSLO_SLOCD", "TSLO_CUSCD", "MCUS_CUSNM", "TSLO_PLAN_DLVDT", "TSLODETA_ITMCD", "MITM_ITMNM");
        return ['data' => $RS->get()];
    }

    public function updateDODetail(Request $request)
    {
        # ubah data header
        $affectedRow = T_DLVORDDETA::on($this->dedicatedConnection)
            ->where('id', $request->id)
            ->update([
                'TDLVORDDETA_ITMQT' => $request->TDLVORDDETA_ITMQT
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    public function save(Request $request)
    {
        # data quotation header
        $validator = Validator::make($request->all(), [
            'TDLVORD_CUSCD' => 'required',
            'TDLVORD_ISSUDT' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $LastLine = DB::connection($this->dedicatedConnection)->table('T_DLVORDHEAD')
            ->whereMonth('created_at', '=', date('m'))
            ->whereYear('created_at', '=', date('Y'))
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->max('TDLVORD_LINE');

        $quotationHeader = [];
        $newQuotationCode = '';
        if (!$LastLine) {
            $LastLine = 1;
            $newQuotationCode = 'SP-0001';
        } else {
            $LastLine++;
            $newQuotationCode = 'SP-' . substr('000' . $LastLine, -4);
        }
        $quotationHeader = [
            'TDLVORD_DLVCD' => $newQuotationCode,
            'TDLVORD_CUSCD' => $request->TDLVORD_CUSCD,
            'TDLVORD_LINE' => $LastLine,
            'TDLVORD_ISSUDT' => $request->TDLVORD_ISSUDT,
            'TDLVORD_BRANCH' => Auth::user()->branch
        ];

        # data quotation detail item
        $validator = Validator::make($request->all(), [
            'TDLVORDDETA_ITMCD' => 'required|array',
            'TDLVORDDETA_ITMQT' => 'required|array',
            'TDLVORDDETA_ITMQT.*' => 'required|numeric',
            'TDLVORDDETA_PRC' => 'required|array',
            'TDLVORDDETA_PRC.*' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }
        $countDetail = count($request->TDLVORDDETA_ITMCD);


        T_DLVORDHEAD::on($this->dedicatedConnection)->create($quotationHeader);
        $quotationDetail = [];
        for ($i = 0; $i < $countDetail; $i++) {
            $quotationDetail[] = [
                'TDLVORDDETA_DLVCD' => $newQuotationCode,
                'TDLVORDDETA_ITMCD' => $request->TDLVORDDETA_ITMCD[$i],
                'TDLVORDDETA_ITMQT' => $request->TDLVORDDETA_ITMQT[$i],
                'TDLVORDDETA_PRC' => $request->TDLVORDDETA_PRC[$i],
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
                'TDLVORDDETA_BRANCH' => Auth::user()->branch,
                'TDLVORDDETA_SLOCD' => $request->TDLVORDDETA_SLOCD[$i]
            ];
        }
        if (!empty($quotationDetail)) {
            T_DLVORDDETA::on($this->dedicatedConnection)->insert($quotationDetail);
        }
        return [
            'msg' => 'OK', 'doc' => $newQuotationCode
        ];
    }

    function loadByDocument(Request $request)
    {
        return [
            'data' => T_DLVORDDETA::on($this->dedicatedConnection)->select('T_DLVORDDETA.id', 'TDLVORDDETA_ITMCD', 'TDLVORDDETA_ITMQT', 'MITM_ITMNM')
                ->leftJoin("M_ITM", function ($join) {
                    $join->on('TDLVORDDETA_ITMCD', '=', 'MITM_ITMCD')->on('TDLVORDDETA_BRANCH', '=', 'MITM_BRANCH');
                })
                ->where('TDLVORDDETA_DLVCD', base64_decode($request->id))
                ->where('TDLVORDDETA_BRANCH', Auth::user()->branch)->get(), 'input' => base64_decode($request->id)
        ];
    }

    function search(Request $request)
    {
        $columnMap = [
            'TDLVORD_DLVCD',
            'MCUS_CUSNM',
        ];
        $RSSub = T_DLVORDDETA::on($this->dedicatedConnection)->select('TDLVORDDETA_DLVCD', 'TDLVORDDETA_BRANCH', DB::raw('MAX(TDLVORDDETA_SLOCD) TDLVORDDETA_SLOCD'))
            ->where('TDLVORDDETA_BRANCH', Auth::user()->branch)
            ->groupBy('TDLVORDDETA_DLVCD', 'TDLVORDDETA_BRANCH');
        $RS = T_DLVORDHEAD::on($this->dedicatedConnection)->select(["TDLVORD_DLVCD", "TDLVORD_CUSCD", "TDLVORD_ISSUDT", "MCUS_CUSNM", 'TDLVORDDETA_SLOCD'])
            ->leftJoin("M_CUS", function ($join) {
                $join->on("TDLVORD_CUSCD", "=", "MCUS_CUSCD")
                    ->on('TDLVORD_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->leftJoinSub($RSSub, 'V1', function ($join) {
                $join->on('TDLVORD_DLVCD', '=', 'TDLVORDDETA_DLVCD')
                    ->on('TDLVORD_BRANCH', '=', 'TDLVORDDETA_BRANCH');
            })
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->get();
        return ['data' => $RS];
    }
}
