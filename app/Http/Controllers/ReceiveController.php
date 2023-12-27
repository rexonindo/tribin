<?php

namespace App\Http\Controllers;

use App\Models\T_PCHORDDETA;
use App\Models\T_RCV_DETAIL;
use App\Models\T_RCV_HEAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

        $groupedColumns = ['TPCHORDDETA_BRANCH', 'TPCHORDDETA_PCHCD', 'TPCHORDDETA_ITMCD', 'TPCHORDDETA_ITMPRC_PER', 'MSUP_SUPCD', 'MSUP_SUPNM', 'TPCHORD_ISSUDT'];
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
            ->groupBy('TPCHORDDETA_PCHCD', 'MSUP_SUPCD', 'MSUP_SUPNM', 'TPCHORD_ISSUDT')
            ->select('TPCHORDDETA_PCHCD', 'MSUP_SUPCD', 'MSUP_SUPNM', 'TPCHORD_ISSUDT')->get();

        return ['data' => $data];
    }

    function outstandingPOPerDocument(Request $request)
    {
        $groupedColumns = ['TPCHORDDETA_BRANCH', 'TPCHORDDETA_PCHCD', 'TPCHORDDETA_ITMCD', 'MITM_ITMNM', 'TPCHORDDETA_ITMPRC_PER', 'MSUP_SUPCD', 'MSUP_SUPNM', 'TPCHORD_ISSUDT'];
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

    function delete(Request $request)
    {
        $affectedRow = T_RCV_DETAIL::on($this->dedicatedConnection)->where('id', $request->id)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::user()->nick_name
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'could not be deleted', 'affectedRow' => $affectedRow];
    }

    function save(Request $request)
    {
        # data quotation header
        $validator = Validator::make($request->all(), [
            'TRCV_SUPCD' => 'required',
            'TRCV_ISSUDT' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $quotationHeader = [
            'TRCV_RCVCD' => $request->TRCV_RCVCD,
            'TRCV_SUPCD' => $request->TRCV_SUPCD,
            'TRCV_ISSUDT' => $request->TRCV_ISSUDT,
            'created_by' => Auth::user()->nick_name,
            'TRCV_BRANCH' => Auth::user()->branch
        ];

        # data quotation detail item
        $validator = Validator::make($request->all(), [
            'item_code' => 'required|array',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric',
            'unit_price' => 'required|array',
            'unit_price.*' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $countDetail = count($request->item_code);

        $createdObj = T_RCV_HEAD::on($this->dedicatedConnection)->create($quotationHeader);
        $quotationDetail = [];
        for ($i = 0; $i < $countDetail; $i++) {
            $quotationDetail[] = [
                'id_header' => $createdObj->id,
                'po_number' => $request->po_number[$i],
                'item_code' => $request->item_code[$i],
                'quantity' => $request->quantity[$i],
                'unit_price' => $request->unit_price[$i],
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
                'branch' => Auth::user()->branch
            ];
        }

        if (!empty($quotationDetail)) {
            T_RCV_DETAIL::on($this->dedicatedConnection)->insert($quotationDetail);
        }

        return [
            'msg' => 'OK', 'doc' => $createdObj->id
        ];
    }

    function loadById(Request $request)
    {
        $documentNumber = base64_decode($request->id);

        $RS = T_RCV_DETAIL::on($this->dedicatedConnection)->select(["id", "po_number",  "item_code", "MITM_ITMNM", "quantity", "unit_price"])
            ->leftJoin("M_ITM", function ($join) {
                $join->on("item_code", "=", "MITM_ITMCD")
                    ->on('branch', '=', 'MITM_BRANCH');
            })
            ->where('id_header', $documentNumber)
            ->where('branch', Auth::user()->branch)
            ->whereNull('deleted_at')->get();


        $RSHeader = T_RCV_HEAD::on($this->dedicatedConnection)
            ->where('id', $documentNumber)
            ->get();


        return [
            'dataItem' => $RS,
            'dataHeader' => $RSHeader
        ];
    }

    function update(Request $request)
    {
        $affectedRow = T_RCV_HEAD::on($this->dedicatedConnection)
            ->where('id', base64_decode($request->id))
            ->where('TRCV_BRANCH', Auth::user()->branch)
            ->whereNull('TRCV_SUBMITTED_AT')
            ->update([
                'TRCV_ISSUDT' => $request->TRCV_ISSUDT, 'TRCV_RCVCD' => $request->TRCV_RCVCD
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
