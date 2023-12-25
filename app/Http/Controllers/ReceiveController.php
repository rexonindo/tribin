<?php

namespace App\Http\Controllers;

use App\Models\T_PCHORDDETA;
use App\Models\T_RCV_DETAIL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ReceiveController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    function index()
    {
        return view('transaction.receive');
    }

    function outstandingPO(Request $request)
    {
        $columnMap = [
            'TPCHORD_PCHCD',
            'MSUP_SUPNM',
        ];

        $groupedColumns = ['TPCHORDDETA_BRANCH', 'TPCHORDDETA_PCHCD', 'TPCHORDDETA_ITMCD', 'TPCHORDDETA_ITMPRC_PER', 'MSUP_SUPNM', 'TPCHORD_ISSUDT'];
        $receivegroupedColumns = ['branch', 'po_number', 'item_code', 'unit_price'];

        $subData = T_PCHORDDETA::on($this->dedicatedConnection)
            ->leftJoin('T_PCHORDHEAD', function ($join) {
                $join->on('TPCHORDDETA_PCHCD', '=', 'TPCHORD_PCHCD')
                    ->on('TPCHORDDETA_BRANCH', '=', 'TPCHORD_BRANCH');
            })
            ->leftJoin('M_SUP', function ($join) {
                $join->on('TPCHORD_SUPCD', '=', 'MSUP_SUPCD')
                    ->on('TPCHORD_BRANCH', '=', 'MSUP_BRANCH');
            })
            ->whereNull('deleted_at')
            ->where('TPCHORDDETA_BRANCH', Auth::user()->branch)
            ->where($columnMap[$request->searchBy], 'LIKE', '%' . $request->searchValue . '%')
            ->groupBy($groupedColumns)
            ->select(array_merge($groupedColumns, [DB::raw("SUM(TPCHORDDETA_ITMQT) AS POQT")]));

        $receivingData = T_RCV_DETAIL::on($this->dedicatedConnection)
            ->where('branch', Auth::user()->branch)
            ->groupBy($receivegroupedColumns)
            ->select(array_merge($receivegroupedColumns, [DB::raw("SUM(quantity) AS RCVQT")]));

        $dataFinal = DB::connection($this->dedicatedConnection)
            ->query()->fromSub($subData, 'V1')
            ->leftJoinSub($receivingData, 'V2', function ($join) {
                $join->on('TPCHORDDETA_BRANCH', '=', 'branch')
                    ->on('TPCHORDDETA_PCHCD', '=', 'po_number')
                    ->on('TPCHORDDETA_ITMCD', '=', 'item_code')
                    ->on('TPCHORDDETA_ITMPRC_PER', '=', 'unit_price');
            })
            ->select(array_merge($groupedColumns, ["POQT", DB::raw("IFNULL(RCVQT,0) AS RCVQT")]))
            ->whereRaw("POQT > IFNULL(RCVQT,0)");

        $data = DB::connection($this->dedicatedConnection)
            ->query()->fromSub($dataFinal, 'V3')
            ->groupBy('TPCHORDDETA_PCHCD', 'MSUP_SUPNM', 'TPCHORD_ISSUDT')
            ->select('TPCHORDDETA_PCHCD', 'MSUP_SUPNM', 'TPCHORD_ISSUDT')->get();

        return ['data' => $data];
    }

    function outstandingPOPerDocument(Request $request)
    {
        $groupedColumns = ['TPCHORDDETA_BRANCH', 'TPCHORDDETA_PCHCD', 'TPCHORDDETA_ITMCD', 'MITM_ITMNM', 'TPCHORDDETA_ITMPRC_PER', 'MSUP_SUPNM', 'TPCHORD_ISSUDT'];
        $receivegroupedColumns = ['branch', 'po_number', 'item_code', 'unit_price'];

        $subData = T_PCHORDDETA::on($this->dedicatedConnection)
            ->leftJoin('T_PCHORDHEAD', function ($join) {
                $join->on('TPCHORDDETA_PCHCD', '=', 'TPCHORD_PCHCD')
                    ->on('TPCHORDDETA_BRANCH', '=', 'TPCHORD_BRANCH');
            })
            ->leftJoin('M_SUP', function ($join) {
                $join->on('TPCHORD_SUPCD', '=', 'MSUP_SUPCD')
                    ->on('TPCHORD_BRANCH', '=', 'MSUP_BRANCH');
            })
            ->leftJoin('M_ITM', function ($join) {
                $join->on('TPCHORDDETA_ITMCD', '=', 'MITM_ITMCD')
                    ->on('TPCHORDDETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->whereNull('deleted_at')
            ->where('TPCHORDDETA_BRANCH', Auth::user()->branch)
            ->where('TPCHORD_PCHCD',  base64_decode($request->id))
            ->groupBy($groupedColumns)
            ->select(array_merge($groupedColumns, [DB::raw("SUM(TPCHORDDETA_ITMQT) AS POQT")]));

        $receivingData = T_RCV_DETAIL::on($this->dedicatedConnection)
            ->where('branch', Auth::user()->branch)
            ->groupBy($receivegroupedColumns)
            ->select(array_merge($receivegroupedColumns, [DB::raw("SUM(quantity) AS RCVQT")]));

        $data = DB::connection($this->dedicatedConnection)
            ->query()->fromSub($subData, 'V1')
            ->leftJoinSub($receivingData, 'V2', function ($join) {
                $join->on('TPCHORDDETA_BRANCH', '=', 'branch')
                    ->on('TPCHORDDETA_PCHCD', '=', 'po_number')
                    ->on('TPCHORDDETA_ITMCD', '=', 'item_code')
                    ->on('TPCHORDDETA_ITMPRC_PER', '=', 'unit_price');
            })
            ->select(array_merge($groupedColumns, ["POQT", DB::raw("IFNULL(RCVQT,0) AS RCVQT, POQT-IFNULL(RCVQT,0) AS BALQT")]))
            ->whereRaw("POQT > IFNULL(RCVQT,0)")->get();

        return ['data' => $data];
    }
}
