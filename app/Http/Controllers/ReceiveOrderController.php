<?php

namespace App\Http\Controllers;

use App\Models\M_USAGE;
use App\Models\T_SLO_DRAFT_DETAIL;
use App\Models\T_SLO_DRAFT_HEAD;
use App\Models\T_SLODETA;
use App\Models\T_SLOHEAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReceiveOrderController extends Controller
{
    protected $dedicatedConnection;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }
    public function index()
    {
        $Usages = M_USAGE::on($this->dedicatedConnection)->get();
        return view('transaction.receive_order', ['usages' => $Usages]);
    }
    public function save(Request $request)
    {
        $monthOfRoma = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

        # data quotation header
        $validator = Validator::make($request->all(), [
            'TSLO_CUSCD' => 'required',
            'TSLO_ATTN' => 'required',
            'TSLO_QUOCD' => 'required',
            'TSLO_ISSUDT' => 'required|date',
            'TSLO_PLAN_DLVDT' => 'required',
            'TSLO_ADDRESS_NAME' => 'required',
            'TSLO_ADDRESS_DESCRIPTION' => 'required',
            'TSLO_TYPE' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $LastLine = DB::connection($this->dedicatedConnection)->table('T_SLOHEAD')
            ->whereMonth('created_at', '=', date('m'))
            ->whereYear('created_at', '=', date('Y'))
            ->where('TSLO_BRANCH', Auth::user()->branch)
            ->max('TSLO_LINE');


        $quotationHeader = [];
        $newDocumentCode = '';
        $newPOCode = '';
        if (!$LastLine) {
            $LastLine = 1;
            $newDocumentCode = '001/PT/SLO/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
        } else {
            $LastLine++;
            $newDocumentCode = substr('00' . $LastLine, -3) . '/PT/SLO/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
        }

        if ($request->TSLO_POCD == '') {
            $POLastLine = DB::connection($this->dedicatedConnection)->table('T_SLOHEAD')
                ->whereMonth('created_at', '=', date('m'))
                ->whereYear('created_at', '=', date('Y'))
                ->max('TSLO_POLINE');
            if (!$POLastLine) {
                $POLastLine = 1;
                $newPOCode = 'A-' . date('Ym') . '-1';
            } else {
                $POLastLine++;
                $newPOCode = 'A-' . date('Ym') . '-' . $POLastLine;
            }
        } else {
            $POLastLine = 0;
            $newPOCode = $request->TSLO_POCD;
        }
        $quotationHeader = [
            'TSLO_SLOCD' => $newDocumentCode,
            'TSLO_CUSCD' => $request->TSLO_CUSCD,
            'TSLO_LINE' => $LastLine,
            'TSLO_ATTN' => $request->TSLO_ATTN,
            'TSLO_QUOCD' => $request->TSLO_QUOCD,
            'TSLO_POCD' => $newPOCode,
            'TSLO_POLINE' => $POLastLine,
            'TSLO_ISSUDT' => $request->TSLO_ISSUDT,
            'TSLO_PLAN_DLVDT' => $request->TSLO_PLAN_DLVDT,
            'TSLO_ADDRESS_NAME' => $request->TSLO_ADDRESS_NAME,
            'TSLO_ADDRESS_DESCRIPTION' => $request->TSLO_ADDRESS_DESCRIPTION,
            'TSLO_MAP_URL' => $request->TSLO_MAP_URL,
            'TSLO_TYPE' => $request->TSLO_TYPE,
            'TSLO_SERVTRANS_COST' => $request->TSLO_SERVTRANS_COST,
            'created_by' => Auth::user()->nick_name,
            'TSLO_BRANCH' => Auth::user()->branch
        ];


        # data quotation detail item
        $validator = Validator::make($request->all(), [
            'TSLODETA_ITMCD' => 'required|array',
            'TSLODETA_USAGE_DESCRIPTION' => 'required|array',
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
                'TSLODETA_USAGE_DESCRIPTION' => $request->TSLODETA_USAGE_DESCRIPTION[$i],
                'TSLODETA_USAGE' => 0,
                'TSLODETA_PRC' => $request->TSLODETA_PRC[$i],
                'TSLODETA_OPRPRC' => $request->TSLODETA_OPRPRC[$i],
                'TSLODETA_MOBDEMOB' => $request->TSLODETA_MOBDEMOB[$i],
                'TSLODETA_PERIOD_FR' => $request->TSLODETA_PERIOD_FR[$i],
                'TSLODETA_PERIOD_TO' => $request->TSLODETA_PERIOD_TO[$i],
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
                'TSLODETA_BRANCH' => Auth::user()->branch
            ];
        }

        T_SLOHEAD::on($this->dedicatedConnection)->create($quotationHeader);
        if (!empty($quotationDetail)) {
            T_SLODETA::on($this->dedicatedConnection)->insert($quotationDetail);
        }

        return [
            'msg' => 'OK', 'doc' => $newDocumentCode, '$RSLast' => $LastLine,
            'quotationHeader' => $quotationHeader,
            'quotationDetail' => $quotationDetail,
            'newPOCode' => $newPOCode,
        ];
    }

    function search(Request $request)
    {
        $columnMap = [
            'TSLO_SLOCD',
            'MCUS_CUSNM',
            'TSLO_POCD',
        ];

        $RS = T_SLOHEAD::on($this->dedicatedConnection)->select([
            "TSLO_SLOCD", "TSLO_CUSCD", "MCUS_CUSNM", "TSLO_ISSUDT", "TSLO_QUOCD", "TSLO_POCD",
            "TSLO_ATTN", "TSLO_PLAN_DLVDT", "TSLO_ADDRESS_NAME", "TSLO_ADDRESS_DESCRIPTION", "TSLO_TYPE", "TSLO_SERVTRANS_COST", 'TSLO_MAP_URL'
        ])
            ->leftJoin("M_CUS", function ($join) {
                $join->on("TSLO_CUSCD", "=", "MCUS_CUSCD")
                    ->on('TSLO_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->where('TSLO_BRANCH', Auth::user()->branch)
            ->get();
        return ['data' => $RS];
    }

    function searchDraft(Request $request)
    {
        $columnMap = [
            'TSLODRAFT_SLOCD',
            'MCUS_CUSNM',
            'TSLODRAFT_POCD',
        ];

        $RS = T_SLO_DRAFT_HEAD::on($this->dedicatedConnection)->select(["TSLODRAFT_SLOCD", "TSLODRAFT_CUSCD", "MCUS_CUSNM", "TSLODRAFT_ISSUDT", "TSLODRAFT_POCD", "TSLODRAFT_ATTN", "MCUS_ADDR1"])
            ->leftJoin("M_CUS", function ($join) {
                $join->on("TSLODRAFT_CUSCD", "=", "MCUS_CUSCD")
                    ->on('TSLODRAFT_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->leftJoin("T_SLOHEAD", function ($join) {
                $join->on("TSLODRAFT_SLOCD", "=", "TSLO_QUOCD")
                    ->on('TSLODRAFT_BRANCH', '=', 'TSLO_BRANCH');
            })
            ->whereNull("TSLO_QUOCD")
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->where('TSLODRAFT_BRANCH', Auth::user()->branch)
            ->get();
        return ['data' => $RS];
    }

    function loadById(Request $request)
    {
        $RS = T_SLODETA::on($this->dedicatedConnection)->select([
            "id", "TSLODETA_ITMCD", "MITM_ITMNM", "TSLODETA_USAGE_DESCRIPTION", "TSLODETA_ITMQT", "TSLODETA_PRC", "TSLODETA_OPRPRC",
            "TSLODETA_MOBDEMOB", 'TSLODETA_PERIOD_FR', 'TSLODETA_PERIOD_TO'
        ])
            ->leftJoin("M_ITM", function ($join) {
                $join->on("TSLODETA_ITMCD", "=", "MITM_ITMCD")
                    ->on('TSLODETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->where('TSLODETA_SLOCD', base64_decode($request->id))
            ->where('TSLODETA_BRANCH', Auth::user()->branch)
            ->whereNull('deleted_at')->get();
        $RSHeader = T_SLOHEAD::on($this->dedicatedConnection)->select('TSLO_TYPE', 'TSLO_SERVTRANS_COST')
            ->where('TSLO_SLOCD', base64_decode($request->id))
            ->where('TSLO_BRANCH', Auth::user()->branch)
            ->get();
        return ['dataItem' => $RS, 'dataHeader' => $RSHeader];
    }

    function loadDraftById(Request $request)
    {
        $RS = T_SLO_DRAFT_DETAIL::on($this->dedicatedConnection)->select(["id", "TSLODRAFTDETA_ITMCD", "MITM_ITMNM", "TSLODRAFTDETA_ITMQT", "TSLODRAFTDETA_ITMPRC_PER"])
            ->leftJoin("M_ITM", function ($join) {
                $join->on("TSLODRAFTDETA_ITMCD", "=", "MITM_ITMCD")
                    ->on('TSLODRAFTDETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->where('TSLODRAFTDETA_SLOCD', base64_decode($request->id))
            ->where('TSLODRAFTDETA_BRANCH', Auth::user()->branch)
            ->whereNull('deleted_at')->get();
        return ['dataItem' => $RS];
    }

    function deleteItemById(Request $request)
    {
        $affectedRow = T_SLODETA::on($this->dedicatedConnection)
            ->where('id', $request->id)
            ->where('TSLODETA_BRANCH', Auth::user()->branch)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::user()->nick_name
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'could not be deleted', 'affectedRow' => $affectedRow];
    }

    public function update(Request $request)
    {
        # ubah data header
        $affectedRow = T_SLOHEAD::on($this->dedicatedConnection)
            ->where('TSLO_SLOCD', base64_decode($request->id))
            ->where('TSLO_BRANCH', Auth::user()->branch)
            ->update([
                'TSLO_CUSCD' => $request->TSLO_CUSCD, 'TSLO_ATTN' => $request->TSLO_ATTN,
                'TSLO_POCD' => $request->TSLO_POCD, 'TSLO_ISSUDT' => $request->TSLO_ISSUDT,
                'TSLO_PLAN_DLVDT' => $request->TSLO_PLAN_DLVDT,
                'TSLO_ADDRESS_NAME' => $request->TSLO_ADDRESS_NAME,
                'TSLO_ADDRESS_DESCRIPTION' => $request->TSLO_ADDRESS_DESCRIPTION,
                'TSLO_MAP_URL' => $request->TSLO_MAP_URL,
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
    public function formReport()
    {
        $Usages = M_USAGE::on($this->dedicatedConnection)->select('MUSAGE_DESCRIPTION')->get();
        return view('report.receive_order', ['Usages' => $Usages]);
    }
    function report(Request $request)
    {
        $RS = T_SLOHEAD::on($this->dedicatedConnection)->select(DB::raw("T_SLOHEAD.*,MCUS_CUSNM,TSLODETA_ITMCD,MITM_ITMNM,TSLODETA_ITMQT,TSLODETA_USAGE_DESCRIPTION,TSLODETA_PRC,TSLODETA_OPRPRC,TSLODETA_MOBDEMOB"))
            ->leftJoin('T_SLODETA', function ($join) {
                $join->on('TSLO_SLOCD', '=', 'TSLODETA_SLOCD')->on('TSLO_BRANCH', '=', 'TSLODETA_BRANCH');
            })
            ->leftJoin('M_ITM', function ($join) {
                $join->on('TSLODETA_ITMCD', '=', 'MITM_ITMCD')->on('TSLODETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->join('M_CUS', function ($join) {
                $join->on('TSLO_CUSCD', '=', 'MCUS_CUSCD')->on('TSLO_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->where("TSLO_ISSUDT", ">=", $request->dateFrom)
            ->where("TSLO_ISSUDT", "<=", $request->dateTo)
            ->where('TSLO_BRANCH', Auth::user()->branch)
            ->get()->toArray();
        if ($request->fileType === 'json') {
            return ['data' => $RS];
        } else {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('RECEIVED-ORDER');
            $sheet->freezePane('A2');

            $sheet->fromArray(array_keys($RS[0]), null, 'A1');
            $sheet->fromArray($RS, null, 'A2');

            foreach (range('A', 'Z') as $r) {
                $sheet->getColumnDimension($r)->setAutoSize(true);
            }

            $stringjudul = "Recived-Order Report " . date('Y-m-d H:i:s');
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $filename = $stringjudul;
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }
    }

    function notificationsDraft()
    {
        $dataTobeUpproved = [];
        $dataPurchaseRequestApproved = [];
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        if (in_array($activeRole['code'], ['marketing', 'marketing_adm'])) {
            # Query untuk data Purchase Order Draft
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_SLO_DRAFT_DETAIL')
                ->selectRaw("COUNT(*) TTLDETAIL, TSLODRAFTDETA_SLOCD")
                ->groupBy("TSLODRAFTDETA_SLOCD")
                ->where('TSLODRAFTDETA_BRANCH', Auth::user()->branch)
                ->whereNull('deleted_at');
            $dataTobeUpproved = T_SLO_DRAFT_HEAD::on($this->dedicatedConnection)->select(DB::raw("TSLODRAFT_SLOCD,max(TTLDETAIL) TTLDETAIL, max(T_SLO_DRAFT_HEAD.created_at) CREATED_AT,max(TSLODRAFT_POCD) TSLODRAFT_POCD"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TSLODRAFT_SLOCD", "=", "TSLODRAFTDETA_SLOCD");
                })
                ->whereNull("TSLODRAFT_APPRVDT")
                ->where('TSLODRAFT_BRANCH', Auth::user()->branch)
                ->groupBy('TSLODRAFT_SLOCD')->get();
        }
        return [
            'data' => $dataTobeUpproved, 'dataApproved' => $dataPurchaseRequestApproved
        ];
    }

    public function formApprovalDraft()
    {
        return view('transaction.sales_order_draft_status');
    }

    public function updateItem(Request $request)
    {
        $affectedRow = 0;
        # ubah data detail
        $affectedRow = T_SLODETA::on($this->dedicatedConnection)
            ->where('id', $request->id)
            ->where('TSLODETA_BRANCH', Auth::user()->branch)
            ->update([
                'TSLODETA_ITMCD' => $request->TSLODETA_ITMCD,
                'TSLODETA_ITMQT' => $request->TSLODETA_ITMQT,
                'TSLODETA_USAGE_DESCRIPTION' => $request->TSLODETA_USAGE_DESCRIPTION,
                'TSLODETA_PRC' => $request->TSLODETA_PRC,
                'TSLODETA_OPRPRC' => $request->TSLODETA_OPRPRC ? $request->TSLODETA_OPRPRC : 0,
                'TSLODETA_MOBDEMOB' => $request->TSLODETA_MOBDEMOB ? $request->TSLODETA_MOBDEMOB : 0,
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
