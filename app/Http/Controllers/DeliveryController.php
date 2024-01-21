<?php

namespace App\Http\Controllers;

use App\Models\ApprovalHistory;
use App\Models\BranchPaymentAccount;
use App\Models\C_ITRN;
use App\Models\C_SPK;
use App\Models\COMPANY_BRANCH;
use App\Models\CompanyGroup;
use App\Models\M_BRANCH;
use App\Models\M_DISTANCE_PRICE;
use App\Models\M_SUP;
use App\Models\T_DLVACCESSORY;
use App\Models\T_DLVORDDETA;
use App\Models\T_DLVORDHEAD;
use App\Models\T_PCHORDDETA;
use App\Models\T_PCHORDHEAD;
use App\Models\T_QUOHEAD;
use App\Models\T_SLODETA;
use App\Models\T_SLOHEAD;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Codedge\Fpdf\Fpdf\Fpdf;

class DeliveryController extends Controller
{
    protected $dedicatedConnection;
    protected $fpdf;
    protected $monthOfRoma = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
        $this->fpdf = new Fpdf;
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

    public function updateDODetailActual(Request $request)
    {
        # ubah data header
        $affectedRow = T_DLVORDDETA::on($this->dedicatedConnection)
            ->where('id', base64_decode($request->id))
            ->update([
                'TDLVORDDETA_ITMCD_ACT' => $request->TDLVORDDETA_ITMCD_ACT
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    public function updateSPK(Request $request)
    {
        $RangePrice = NULL;
        $UANG_JALAN = 0;
        if ($request->CSPK_PIC_AS === 'DRIVER') {
            $RangePrice = M_DISTANCE_PRICE::on($this->dedicatedConnection)->select('*')
                ->where('RANGE2', '>=', $request->CSPK_KM)
                ->where('BRANCH', Auth::user()->branch)
                ->orderBy('RANGE1', 'ASC')
                ->first();

            if (!$RangePrice) {
                return response()->json([['Distance out of range, please register on distance price master']], 406);
            }
            $UANG_JALAN = $request->CSPK_WHEELS == 10 ? $RangePrice->PRICE_WHEEL_10 : $RangePrice->PRICE_WHEEL_4_AND_6;
        }

        # ubah data header
        $affectedRow = C_SPK::on($this->dedicatedConnection)
            ->where('id', base64_decode($request->id))
            ->update([
                'CSPK_PIC_AS' => $request->CSPK_PIC_AS,
                'CSPK_PIC_NAME' => $request->CSPK_PIC_NAME,
                'CSPK_KM' => $request->CSPK_KM ?? 0,
                'CSPK_WHEELS' => $request->CSPK_WHEELS,
                'CSPK_UANG_JALAN' => $UANG_JALAN,
                'CSPK_SUPPLIER' => $request->CSPK_SUPPLIER,
                'CSPK_LITER_EXISTING' => $request->CSPK_LITER_EXISTING,
                'CSPK_LITER' => $request->CSPK_LITER,
                'CSPK_UANG_SOLAR' => $request->CSPK_SUPPLIER == 'SPBU' ? 6800 * $request->CSPK_LITER : 10000 * $request->CSPK_LITER,
                'CSPK_UANG_MAKAN' => $request->CSPK_UANG_MAKAN,
                'CSPK_UANG_MANDAH' => $request->CSPK_UANG_MANDAH,
                'CSPK_UANG_PENGINAPAN' => $request->CSPK_UANG_PENGINAPAN,
                'CSPK_UANG_PENGAWALAN' => $request->CSPK_UANG_PENGAWALAN,
                'CSPK_UANG_LAIN2' => $request->CSPK_UANG_LAIN2,
                'CSPK_LEAVEDT' => $request->CSPK_LEAVEDT,
                'CSPK_BACKDT' => $request->CSPK_BACKDT,
                'CSPK_VEHICLE_TYPE' => $request->CSPK_VEHICLE_TYPE ?? '',
                'CSPK_VEHICLE_REGNUM' => $request->CSPK_VEHICLE_REGNUM,
                'CSPK_JOBDESK' => $request->CSPK_JOBDESK,
                'updated_by' => Auth::user()->nick_name,
                'submitted_by' => null,
                'submitted_at' => null,
            ]);

        if ($affectedRow) {
            ApprovalHistory::on($this->dedicatedConnection)->create([
                'created_by' => Auth::user()->nick_name,
                'form' => 'SPK',
                'code' => base64_decode($request->id),
                'type' => '2',
                'remark' => 'EDITED',
                'branch' => Auth::user()->branch,
            ]);
        }
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    public function save(Request $request)
    {
        $monthOfRoma = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

        # data quotation header
        $validator = Validator::make($request->all(), [
            'TDLVORD_CUSCD' => 'required',
            'TDLVORD_ISSUDT' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $Company = COMPANY_BRANCH::on($this->dedicatedConnection)->select(
            'invoice_letter_id'
        )
            ->where('connection', $this->dedicatedConnection)
            ->where('BRANCH', Auth::user()->branch)
            ->first();

        $LastLine = DB::connection($this->dedicatedConnection)->table('T_DLVORDHEAD')
            ->whereYear('created_at', '=', date('Y'))
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->max('TDLVORD_LINE');

        $quotationHeader = [];
        $newQuotationCode = '';
        $newInvoiceCode = '';
        if (!$LastLine) {
            $LastLine = 1;
            $newQuotationCode = 'SP-' . date('y') . '-0001';
            $newInvoiceCode = $LastLine . '/' . $Company->invoice_letter_id . '/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
        } else {
            $LastLine++;
            $newQuotationCode = 'SP-' . date('y') . '-' . substr('000' . $LastLine, -4);
            $newInvoiceCode = $LastLine . '/' . $Company->invoice_letter_id . '/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
        }
        $quotationHeader = [
            'TDLVORD_DLVCD' => $newQuotationCode,
            'TDLVORD_CUSCD' => $request->TDLVORD_CUSCD,
            'TDLVORD_LINE' => $LastLine,
            'TDLVORD_ISSUDT' => $request->TDLVORD_ISSUDT,
            'TDLVORD_REMARK' => $request->TDLVORD_REMARK,
            'TDLVORD_INVCD' => $newInvoiceCode,
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
            'msg' => 'OK',
            'doc' => $newQuotationCode,
            'docInvoice' => $newInvoiceCode,
        ];
    }

    function update(Request $request)
    {
        # ubah data header
        $affectedRow = T_DLVORDHEAD::on($this->dedicatedConnection)
            ->where('TDLVORD_DLVCD', base64_decode($request->id))
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->update([
                'TDLVORD_REMARK' => $request->TDLVORD_REMARK,
                'TDLVORD_ISSUDT' => $request->TDLVORD_ISSUDT,
                'updated_by' => Auth::user()->nick_name,
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    function loadByDocument(Request $request)
    {
        $DONUM =  base64_decode($request->id);
        $OrderDetail = T_DLVORDDETA::on($this->dedicatedConnection)->select(
            'T_DLVORDDETA.id',
            'TDLVORDDETA_ITMCD',
            'TDLVORDDETA_ITMQT',
            'ITM.MITM_ITMNM',
            'TDLVORDDETA_SLOCD',
            'TDLVORDDETA_ITMCD_ACT',
            'ITMACT.MITM_ITMNM AS ITMNM_ACT',
        )
            ->leftJoin("M_ITM AS ITM", function ($join) {
                $join->on('TDLVORDDETA_ITMCD', '=', 'ITM.MITM_ITMCD')->on('TDLVORDDETA_BRANCH', '=', 'ITM.MITM_BRANCH');
            })
            ->leftJoin("M_ITM AS ITMACT", function ($join) {
                $join->on('TDLVORDDETA_ITMCD_ACT', '=', 'ITMACT.MITM_ITMCD')->on('TDLVORDDETA_BRANCH', '=', 'ITMACT.MITM_BRANCH');
            })
            ->where('TDLVORDDETA_DLVCD', $DONUM)
            ->where('TDLVORDDETA_BRANCH', Auth::user()->branch)->get();
        $SalesOrderNumber = NULL;
        foreach ($OrderDetail as $r) {
            $SalesOrderNumber = $r->TDLVORDDETA_SLOCD;
            break;
        }
        $SalesOrder = T_SLOHEAD::on($this->dedicatedConnection)->select('TSLO_ADDRESS_NAME', 'TSLO_ADDRESS_DESCRIPTION', 'TSLO_MAP_URL')
            ->where('TSLO_SLOCD', $SalesOrderNumber)
            ->where('TSLO_BRANCH', Auth::user()->branch)
            ->get();
        return [
            'data' => $OrderDetail,
            'input' => base64_decode($request->id),
            'SalesOrder' => $SalesOrder,
            'SPK' => C_SPK::on($this->dedicatedConnection)
                ->leftJoin('users', 'CSPK_PIC_NAME', '=', 'nick_name')
                ->where('CSPK_REFF_DOC', $DONUM)
                ->where('CSPK_BRANCH', Auth::user()->branch)
                ->whereNull('deleted_at')
                ->select(
                    'C_SPK.id',
                    'CSPK_PIC_NAME',
                    'CSPK_PIC_AS',
                    'CSPK_PIC_NAME',
                    'CSPK_KM',
                    'CSPK_WHEELS',
                    'CSPK_UANG_JALAN',
                    'CSPK_SUPPLIER',
                    'CSPK_LITER_EXISTING',
                    'CSPK_LITER',
                    'CSPK_UANG_SOLAR',
                    'CSPK_UANG_MAKAN',
                    'CSPK_UANG_MANDAH',
                    'CSPK_UANG_PENGINAPAN',
                    'CSPK_UANG_PENGAWALAN',
                    'CSPK_UANG_LAIN2',
                    'CSPK_LEAVEDT',
                    'CSPK_BACKDT',
                    'CSPK_VEHICLE_TYPE',
                    'CSPK_VEHICLE_REGNUM',
                    'CSPK_JOBDESK',
                    'CSPK_JOBDESK',
                    'submitted_by',
                    'submitted_at',
                )
                ->get()
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
        $RS = T_DLVORDHEAD::on($this->dedicatedConnection)->select([
            "TDLVORD_DLVCD", "TDLVORD_CUSCD", "TDLVORD_ISSUDT",
            "MCUS_CUSNM", 'TDLVORDDETA_SLOCD', 'TDLVORD_REMARK', 'TDLVORD_INVCD'
        ])
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

    function toPDF(Request $request)
    {
        $doc = base64_decode($request->id);
        $RSHeader = T_DLVORDHEAD::on($this->dedicatedConnection)->select('TDLVORD_ISSUDT', 'MCUS_CUSNM', 'MCUS_ADDR1', 'TDLVORD_REMARK', 'MCUS_TELNO', 'TDLVORD_INVCD', 'TDLVORD_LINE')
            ->leftJoin('M_CUS', function ($join) {
                $join->on('TDLVORD_CUSCD', '=', 'MCUS_CUSCD')->on('TDLVORD_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->where("TDLVORD_DLVCD", $doc)
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->first();
        $DOIssuDate = date_format(date_create($RSHeader->TDLVORD_ISSUDT), 'd-M-Y');
        $branchPaymentAccount = BranchPaymentAccount::on($this->dedicatedConnection)
            ->where('BRANCH', Auth::user()->branch)
            ->whereNull('deleted_at')
            ->get();
        $Branch = M_BRANCH::select('MBRANCH_NM')->where('MBRANCH_CD', Auth::user()->branch)->first();
        $Company = COMPANY_BRANCH::on($this->dedicatedConnection)->select(
            'name',
            'COMPANY_BRANCHES.address',
            'COMPANY_BRANCHES.phone',
            'invoice_letter_id'
        )
            ->where('connection', $this->dedicatedConnection)
            ->where('BRANCH', Auth::user()->branch)
            ->first();
        $RSDetail = T_DLVORDDETA::on($this->dedicatedConnection)->select(
            'TDLVORDDETA_ITMCD',
            'TDLVORDDETA_ITMQT',
            'MITM_ITMNM',
            'MITM_STKUOM',
            'created_by',
            'TDLVORDDETA_SLOCD',
            'MITM_ITMNM',
            'MITM_MODEL',
            'MITM_BRAND',
        )
            ->leftJoin('M_ITM', function ($join) {
                $join->on('TDLVORDDETA_ITMCD', '=', 'MITM_ITMCD')->on('TDLVORDDETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->where('TDLVORDDETA_DLVCD', $doc)
            ->where('TDLVORDDETA_BRANCH', Auth::user()->branch)->get();

        $Dibuat = NULL;
        $Attn = NULL;
        $Subject = NULL;

        $Usage = NULL;
        $HargaSewa = NULL;
        foreach ($RSDetail as $r) {
            $Dibuat = User::where('nick_name', $r->created_by)->select('name')->first();
            $Attn = T_SLOHEAD::on($this->dedicatedConnection)->select('TSLO_ATTN', 'TSLO_QUOCD', 'TSLO_POCD', 'TSLO_ADDRESS_DESCRIPTION')
                ->where('TSLO_SLOCD', $r->TDLVORDDETA_SLOCD)
                ->where('TSLO_BRANCH', Auth::user()->branch)
                ->first();

            $Subject = T_QUOHEAD::on($this->dedicatedConnection)->select('TQUO_SBJCT')
                ->where('TQUO_QUOCD', $Attn->TSLO_QUOCD)
                ->where('TQUO_BRANCH', Auth::user()->branch)
                ->first();
            break;
        }
        if (substr($_COOKIE['JOS_PRINT_FORM'], 0, 1) == '1') {
            $this->fpdf->AddPage("L", 'A5');
            $this->fpdf->SetAutoPageBreak(true, 0);
            $this->fpdf->SetFont('Arial', 'B', 12);
            $this->fpdf->SetXY(3, 5);
            $this->fpdf->Cell(45, 5, $Company->name, 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->SetXY(3, 10);
            $this->fpdf->MultiCell(70, 4, $Company->address . ' Telp.' . $Company->phone, 0, 'L');

            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->SetXY(150, 5);
            $this->fpdf->Cell(45, 5, $Branch->MBRANCH_NM . ', ' . $DOIssuDate, 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->SetXY(150, 10);
            $this->fpdf->MultiCell(55, 4, 'Kepada ' . $RSHeader->MCUS_CUSNM, 0, 'L');

            $this->fpdf->SetFont('Arial', 'U', 10);
            $this->fpdf->SetXY(90, 15);
            $this->fpdf->Cell(29, 5, 'SURAT JALAN', 0, 0, 'C');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->SetXY(90, 20);
            $this->fpdf->Cell(29, 5, 'NO : ' . $doc, 0, 0, 'C');

            $this->fpdf->SetFont('Arial', '', 9);
            $this->fpdf->SetXY(3, 30);
            $this->fpdf->Cell(29, 5, 'Dengan kendaraan No. Pol: , kami kirimkan barang-barang di bawah ini :', 0, 0, 'L');
            $this->fpdf->Line(3, 35, 205, 35);
            $this->fpdf->Line(3, 36, 205, 36);
            $this->fpdf->Line(3, 42, 205, 42);
            $this->fpdf->Line(3, 43, 205, 43);

            # body
            $nomor = 1;
            $Y = 45;
            foreach ($RSDetail as $r) {
                $this->fpdf->SetXY(3, $Y);
                $this->fpdf->Cell(12, 5, $nomor++, 0, 0, 'L');
                $this->fpdf->Cell(40, 5, $r->TDLVORDDETA_ITMCD, 0, 0, 'L');
                $this->fpdf->Cell(67, 5, $r->MITM_ITMNM, 0, 0, 'L');
                $this->fpdf->Cell(20, 5, $r->TDLVORDDETA_ITMQT . ' ' . $r->MITM_STKUOM, 0, 0, 'R');
                $Y += 5;
            }

            # baris bawah
            $this->fpdf->Line(3, 90, 205, 90);
            $this->fpdf->Line(3, 91, 205, 91);
            $this->fpdf->Line(3, 97, 205, 97);
            $this->fpdf->Line(3, 98, 205, 98);
            $this->fpdf->SetXY(3, 36.5);
            $this->fpdf->Cell(29, 5, 'No', 0, 0, 'L');
            $this->fpdf->SetXY(15, 36.5);
            $this->fpdf->Cell(29, 5, 'Part Number', 0, 0, 'L');
            $this->fpdf->SetXY(55, 36.5);
            $this->fpdf->Cell(29, 5, 'Nama Barang', 0, 0, 'L');
            $this->fpdf->SetXY(135, 36.5);
            $this->fpdf->Cell(29, 5, 'Qty', 0, 0, 'L');
            $this->fpdf->SetXY(150, 36.5);
            $this->fpdf->Cell(29, 5, 'Lokasi Barang', 0, 0, 'L');

            $this->fpdf->SetXY(3, 92);
            $this->fpdf->Cell(29, 5, 'Ket:' . $RSHeader->TDLVORD_REMARK, 0, 0, 'L');

            $this->fpdf->SetFont('Arial', '', 7);
            $this->fpdf->SetXY(3, 107);
            $this->fpdf->Cell(29, 5, '- Jam Kerja (08:00-16:00), di luar jam kerja ditambah biaya lembur 50% (forklift)', 0, 0, 'L');
            $this->fpdf->SetXY(3, 110);
            $this->fpdf->Cell(29, 5, '- Bila terjadi sesuatu kecelakaan/kerusakan barang di waktu kerja, semuanya ditanggung oleh penyewa', 0, 0, 'L');

            $this->fpdf->SetFont('Arial', '', 9);
            $this->fpdf->SetXY(10, 115);
            $this->fpdf->Cell(52, 5, 'Penerima', 0, 0, 'L');
            $this->fpdf->Cell(48, 5, 'Sopir', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, 'Ks. Gudang', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, 'Dibuat Oleh', 0, 0, 'L');
            $this->fpdf->SetXY(9, 138);
            $this->fpdf->Cell(50, 2, '(                   )', 0, 0, 'L');
            $this->fpdf->Cell(50, 2, '(                   )', 0, 0, 'L');
            $this->fpdf->Cell(50, 2, '(                       )', 0, 0, 'L');
            $this->fpdf->Cell(5, 2, '(' . $Dibuat->name . ')', 0, 0, 'L');
        }

        $subjek = ucwords(trim(str_replace('penawaran', '', strtolower($Subject->TQUO_SBJCT))));

        if (substr($_COOKIE['JOS_PRINT_FORM'], 1, 1) == '1') {
            $this->fpdf->AddPage("P", 'A4');
            $this->fpdf->SetFont('Arial', 'B', 17);
            $this->fpdf->SetXY(7, 5);
            $this->fpdf->Cell(0, 8, $Company->name, 0, 0, 'C');
            $this->fpdf->SetFont('Arial', '', 11);
            $this->fpdf->SetXY(7, 11);
            $this->fpdf->Cell(0, 7, "Alamat Kantor : " . $Company->address, 0, 0, 'C');
            $this->fpdf->Line(3, 19, 205, 19);

            $this->fpdf->SetFont('Arial', 'B', 17);
            $this->fpdf->SetXY(7, 20);
            $this->fpdf->Cell(0, 8, 'INVOICE', 0, 0, 'C');

            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->SetXY(7, 27);
            $this->fpdf->Cell(20, 5, 'To', 0, 0, 'L');
            $this->fpdf->Cell(20, 5, ': ' . $RSHeader->MCUS_CUSNM, 0, 0, 'L');
            $this->fpdf->SetXY(7, 32);
            $this->fpdf->Cell(20, 5, 'Attn.', 0, 0, 'L');
            $this->fpdf->Cell(20, 5, ': ' . $Attn->TSLO_ATTN, 0, 0, 'L');
            $this->fpdf->SetXY(7, 37);
            $this->fpdf->Cell(20, 5, 'Telp. / Fax', 0, 0, 'L');
            $this->fpdf->Cell(20, 5, ': ' . $RSHeader->MCUS_TELNO, 0, 0, 'L');
            $this->fpdf->SetXY(7, 42);
            $this->fpdf->Cell(20, 5, 'Subject', 0, 0, 'L');
            $this->fpdf->Cell(20, 5, ': ' . $subjek, 0, 0, 'L');

            $this->fpdf->SetXY(130, 27);
            $this->fpdf->Cell(20, 5, 'No', 0, 0, 'L');
            $this->fpdf->Cell(20, 5, ': ' . $RSHeader->TDLVORD_INVCD, 0, 0, 'L');
            $this->fpdf->SetXY(130, 32);
            $this->fpdf->Cell(20, 5, 'Date.', 0, 0, 'L');
            $this->fpdf->Cell(20, 5, ': ' . $DOIssuDate, 0, 0, 'L');
            $this->fpdf->SetXY(130, 37);
            $this->fpdf->Cell(20, 5, 'Telp. / Fax', 0, 0, 'L');
            $this->fpdf->Cell(20, 5, ': ' . $Company->phone, 0, 0, 'L');

            $this->fpdf->SetXY(7, 50);
            $this->fpdf->Cell(20, 5, 'Dengan hormat,', 0, 0, 'L');
            $this->fpdf->SetXY(7, 55);
            $this->fpdf->MultiCell(195, 5, 'Bersama ini kami lakukan penagihan atas ' . $subjek . ' dengan rincian sebagai berikut :');
            $Yfocus = $this->fpdf->GetY();
            $Yfocus += 5;
            $this->fpdf->SetXY(7, $Yfocus);
            $this->fpdf->Cell(50, 5, 'NO. PR', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, ': ' . $Attn->TSLO_POCD, 0, 0, 'L');
            $Yfocus += 5;
            $this->fpdf->SetXY(6, $Yfocus);
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Cell(30, 5, 'Merk', 1, 0, 'C');
            $this->fpdf->Cell(45, 5, 'Capacity / Model', 1, 0, 'C');
            $this->fpdf->Cell(70, 5, 'Pemakaian / Periode', 1, 0, 'C');
            $this->fpdf->Cell(10, 5, 'Qty', 1, 0, 'C');
            $this->fpdf->Cell(45, 5, 'Total Harga Sewa', 1, 0, 'C');
            $Yfocus += 5;
            $this->fpdf->SetFont('Arial', '', 10);
            $totalHargaSewa = 0;
            foreach ($RSDetail as $r) {
                $Usage = T_SLODETA::on($this->dedicatedConnection)->select(
                    'TSLODETA_USAGE_DESCRIPTION',
                    'TSLODETA_PRC',
                    'TSLODETA_OPRPRC',
                    'TSLODETA_MOBDEMOB',
                    'TSLODETA_PERIOD_FR',
                    'TSLODETA_PERIOD_TO',
                )
                    ->where('TSLODETA_SLOCD', $r->TDLVORDDETA_SLOCD)
                    ->where('TSLODETA_ITMCD', $r->TDLVORDDETA_ITMCD)
                    ->where('TSLODETA_BRANCH', Auth::user()->branch)
                    ->first();
                $HargaSewa = ($Usage->TSLODETA_PRC * $r->TDLVORDDETA_ITMQT) + $Usage->TSLODETA_OPRPRC + $Usage->TSLODETA_MOBDEMOB;
                $PeriodFrom = date_format(date_create($Usage->TSLODETA_PERIOD_FR), 'd-M-Y');
                $PeriodTo = date_format(date_create($Usage->TSLODETA_PERIOD_TO), 'd-M-Y');
                $this->fpdf->SetXY(6, $Yfocus);
                $this->fpdf->Cell(30, 10, $r->MITM_BRAND, 1, 0, 'C');
                $this->fpdf->Cell(45, 10, '', 1, 0, 'C');
                $this->fpdf->Text(37, $Yfocus + 4, $r->MITM_ITMNM);
                $this->fpdf->Text(37, $Yfocus + 8, $r->MITM_MODEL);

                $this->fpdf->Cell(70, 10, '', 1, 0, 'C');
                $ttlwidth = $this->fpdf->GetStringWidth($Usage->TSLODETA_USAGE_DESCRIPTION);
                if ($ttlwidth > 70) {
                    $ukuranfont = 9.5;
                    while ($ttlwidth > 70) {
                        $this->fpdf->SetFont('Arial', '', $ukuranfont);
                        $ttlwidth = $this->fpdf->GetStringWidth($Usage->TSLODETA_USAGE_DESCRIPTION);
                        $ukuranfont = $ukuranfont - 0.5;
                    }
                }
                $this->fpdf->Text(82, $Yfocus + 3, $Usage->TSLODETA_USAGE_DESCRIPTION);

                $this->fpdf->SetFont('Arial', '', 10);
                $this->fpdf->Text(82, $Yfocus + 8, $PeriodFrom . ' s/d ' . $PeriodTo);

                $this->fpdf->SetXY(151, $Yfocus);
                $this->fpdf->Cell(10, 10, $r->TDLVORDDETA_ITMQT, 1, 0, 'C');
                $this->fpdf->Cell(45, 10, number_format($HargaSewa), 1, 0, 'C');
                $Yfocus += 10;
                $totalHargaSewa += $HargaSewa;
            }
            $Yfocus += 5;
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->SetXY(7, $Yfocus);
            $this->fpdf->Cell(50, 5, 'Total', 0, 0, 'L');
            $this->fpdf->Cell(3, 5, ':', 0, 0, 'L');
            $this->fpdf->Cell(25, 5, ' ' . number_format($totalHargaSewa), 0, 0, 'R');

            $Yfocus += 5;
            $this->fpdf->SetXY(7, $Yfocus);
            if (in_array($this->dedicatedConnection, ['connect_jos_retail', 'connect_jos_service'])) {
                $PPNAmount = 0;
                $this->fpdf->Cell(50, 5, 'PPN 0%', 0, 0, 'L');
            } else {
                $PPNAmount = $totalHargaSewa * 11 / 100;
                $this->fpdf->Cell(50, 5, 'PPN 11%', 0, 0, 'L');
            }

            $this->fpdf->Cell(3, 5, ':', 0, 0, 'L');
            $this->fpdf->Cell(25, 5, ' ' . number_format($PPNAmount), 0, 0, 'R');

            $Yfocus += 5;
            $this->fpdf->SetXY(7, $Yfocus);
            $this->fpdf->Cell(50, 5, 'Total Tagihan', 0, 0, 'L');
            $this->fpdf->Cell(3, 5, ':', 0, 0, 'L');
            $this->fpdf->Cell(25, 5, ' ' . number_format($PPNAmount + $totalHargaSewa), 0, 0, 'R');

            $Yfocus += 5;
            $this->fpdf->SetXY(7, $Yfocus);
            $terbilang = ucwords(rtrim($this->numberToSentence($PPNAmount + $totalHargaSewa)));
            $this->fpdf->Cell(0, 5, '( ' . $terbilang  . ' )', 0, 0, 'C');

            $this->fpdf->SetFont('Arial', '', 10);
            $Yfocus += 10;
            $this->fpdf->SetXY(7, $Yfocus);
            $this->fpdf->MultiCell(195, 5, 'Invoice/tagihan tersebut agar dapat ditransfer ke rekening kami sebagai berikut :');

            $Yfocus += 10;
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->SetXY(6, $Yfocus);
            $this->fpdf->Cell(80, 5, 'BANK', 1, 0, 'C');
            $this->fpdf->Cell(70, 5, 'Atas Nama', 1, 0, 'C');
            $this->fpdf->Cell(50, 5, 'Nomor Rekening', 1, 0, 'C');
            $Yfocus += 5;
            $this->fpdf->SetFont('Arial', '', 10);
            foreach ($branchPaymentAccount as $r) {
                $this->fpdf->SetXY(6, $Yfocus);
                $this->fpdf->Cell(80, 5, $r->bank_name, 1, 0, 'C');
                $this->fpdf->Cell(70, 5, $r->bank_account_name, 1, 0, 'C');
                $this->fpdf->Cell(50, 5, $r->bank_account_number, 1, 0, 'C');
                $Yfocus += 5;
            }

            $Yfocus += 10;
            $this->fpdf->SetXY(7, $Yfocus);
            $this->fpdf->MultiCell(195, 5, 'Pada keterangan slip transfer mohon diisi sejelas-jelasnya, seperti nama penyewa, periode, nomor invoice dan sebagainya.');
            $Yfocus += 5;
            $this->fpdf->SetXY(7, $Yfocus);
            $this->fpdf->MultiCell(195, 5, 'Untuk Pembayaran yang menggunakan Bilyet Giro/Cheque, dianggap lunas jika dana sudah masuk ke rekening kami.');
            $Yfocus += 10;
            $this->fpdf->SetXY(7, $Yfocus);
            $this->fpdf->MultiCell(195, 5, 'Demikian Invoice kami buat, atas perhatian dan kerjasama yang baik kami sampaikan terima kasih.');
            $Yfocus += 20;
            $this->fpdf->SetXY(7, $Yfocus);
            $this->fpdf->MultiCell(195, 5, 'Hormat kami,');
            $Yfocus += 20;
            $this->fpdf->SetXY(7, $Yfocus);
            $this->fpdf->SetFont('Arial', 'U', 10);
            $this->fpdf->MultiCell(195, 5, '( Syapril, S.T )');
            $Yfocus += 5;
            $this->fpdf->SetXY(10, $Yfocus);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Cell(10, 5, 'Direktur');
        }

        if (substr($_COOKIE['JOS_PRINT_FORM'], 2, 1) == '1') {
            $totalHargaSewa = 0;
            foreach ($RSDetail as $r) {
                $Usage = T_SLODETA::on($this->dedicatedConnection)->select(
                    'TSLODETA_USAGE_DESCRIPTION',
                    'TSLODETA_PRC',
                    'TSLODETA_OPRPRC',
                    'TSLODETA_MOBDEMOB',
                    'TSLODETA_PERIOD_FR',
                    'TSLODETA_PERIOD_TO',
                )
                    ->where('TSLODETA_SLOCD', $r->TDLVORDDETA_SLOCD)
                    ->where('TSLODETA_ITMCD', $r->TDLVORDDETA_ITMCD)
                    ->where('TSLODETA_BRANCH', Auth::user()->branch)
                    ->first();
                $HargaSewa = ($Usage->TSLODETA_PRC * $r->TDLVORDDETA_ITMQT)  + $Usage->TSLODETA_OPRPRC + $Usage->TSLODETA_MOBDEMOB;
                $PeriodFrom = date_format(date_create($Usage->TSLODETA_PERIOD_FR), 'd-M-Y');
                $PeriodTo = date_format(date_create($Usage->TSLODETA_PERIOD_TO), 'd-M-Y');
                $totalHargaSewa += $HargaSewa;
                $DOIssuDate = date_format(date_create($RSHeader->TDLVORD_ISSUDT), 'd-M-Y');
            }
            if (in_array($this->dedicatedConnection, ['connect_jos_retail', 'connect_jos_service'])) {
                $PPNAmount = 0;
            } else {
                $PPNAmount = $totalHargaSewa * 11 / 100;
            }
            $terbilang = ucwords(rtrim($this->numberToSentence($PPNAmount + $totalHargaSewa)));
            $this->fpdf->AddPage("L", 'A5');
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->SetXY(7, 5);
            $this->fpdf->Cell(0, 8, $Company->name, 0, 0, 'L');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->SetXY(7, 12);
            $this->fpdf->MultiCell(95, 4, $Company->address,  0, 'L');
            $this->fpdf->SetFont('Arial', 'B', 14);
            $this->fpdf->SetXY(7, 20);
            $this->fpdf->Cell(0, 8, 'K W I T A N S I', 0, 0, 'C');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->SetXY(7, 30);
            $this->fpdf->Cell(15, 5, 'Nomor', 0, 0, 'L');
            $this->fpdf->Cell(15, 5, ': ' . $RSHeader->TDLVORD_INVCD, 0, 0, 'L');
            $this->fpdf->SetXY(7, 35);
            $this->fpdf->Cell(195, 110, '', 1, 0, 'L');
            $this->fpdf->SetXY(10, 40);
            $this->fpdf->Cell(50, 5, 'Sudah terima dari', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, ': ' . $RSHeader->MCUS_CUSNM, 0, 0, 'L');
            $this->fpdf->Line(63, 46, 180, 46);
            $this->fpdf->SetXY(10, 50);
            $this->fpdf->Cell(50, 5, 'Alamat', 0, 0, 'L');
            $this->fpdf->Cell(2, 5, ':');
            $this->fpdf->MultiCell(138, 5,  $RSHeader->MCUS_ADDR1);
            $this->fpdf->Line(63, $this->fpdf->GetY() + 2, 180, $this->fpdf->GetY() + 2);
            $Yfocus = $this->fpdf->GetY() + 5;
            $this->fpdf->SetXY(10, $Yfocus);
            $this->fpdf->Cell(50, 5, 'Terbilang', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, ': ' . $terbilang, 0, 0, 'L');
            $this->fpdf->Line(63, $Yfocus + 7, 180, $Yfocus + 7);

            $Yfocus += 10;
            $this->fpdf->SetXY(10, $Yfocus);
            $this->fpdf->Cell(50, 5, 'Untuk Pembayaran', 0, 0, 'L');
            $this->fpdf->Cell(2, 5, ':');
            $this->fpdf->MultiCell(138, 5, $subjek . ' Periode ' . $PeriodFrom . ' s/d ' . $PeriodTo);
            $Yfocus = $this->fpdf->GetY() + 5;
            $this->fpdf->Line(63, $Yfocus - 3, 180, $Yfocus - 3);

            $this->fpdf->SetXY(10, $Yfocus);
            $this->fpdf->Cell(50, 5, '', 0, 0, 'L');
            $this->fpdf->Cell(40, 5, ' Total', 0, 0, 'L');
            $this->fpdf->Cell(10, 5, ' : Rp. ', 0, 0, 'L');
            $this->fpdf->Cell(40, 5, number_format($totalHargaSewa), 0, 0, 'R');
            $Yfocus += 5;
            $this->fpdf->SetXY(10, $Yfocus);
            $this->fpdf->Cell(50, 5, '', 0, 0, 'L');
            if (in_array($this->dedicatedConnection, ['connect_jos_retail', 'connect_jos_service'])) {
                $this->fpdf->Cell(40, 5, ' PPN 0%', 0, 0, 'L');
            } else {
                $this->fpdf->Cell(40, 5, ' PPN 11%', 0, 0, 'L');
            }
            $this->fpdf->Cell(10, 5, ' : Rp. ', 0, 0, 'L');
            $this->fpdf->Cell(40, 5, number_format($PPNAmount), 0, 0, 'R');
            $this->fpdf->Line(62, $Yfocus + 5, 100, $Yfocus + 5);
            $this->fpdf->Line(110, $Yfocus + 5, 150, $Yfocus + 5);
            $Yfocus += 6;
            $this->fpdf->SetXY(10, $Yfocus);
            $this->fpdf->Cell(50, 5, '', 0, 0, 'L');
            $this->fpdf->Cell(40, 5, ' Total Yang Dibayar', 0, 0, 'L');
            $this->fpdf->Cell(10, 5, ' : Rp. ', 0, 0, 'L');
            $this->fpdf->Cell(40, 5, number_format($PPNAmount + $totalHargaSewa), 0, 0, 'R');
            $Yfocus += 6;
            $this->fpdf->SetXY(10, $Yfocus);
            $this->fpdf->Cell(50, 5, 'Lokasi', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, ': ' . $Attn->TSLO_ADDRESS_DESCRIPTION, 0, 0, 'L');
            $this->fpdf->Line(63, $Yfocus + 5, 150, $Yfocus + 5);
            $Yfocus += 5;
            $this->fpdf->SetXY(110, $Yfocus);
            $this->fpdf->Cell(50, 5, $Branch->MBRANCH_NM . ', ' . $DOIssuDate, 0, 0, 'L');
            $Yfocus += 10;
            $this->fpdf->SetXY(10, $Yfocus);
            $this->fpdf->Cell(50, 5, 'Jumlah', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, ': Rp. ' . number_format($PPNAmount + $totalHargaSewa), 0, 0, 'L');
            $Yfocus += 15;
            $this->fpdf->SetXY(120, $Yfocus);
            $this->fpdf->Cell(50, 5, 'Syapril, S.T', 0, 0, 'L');
            $Yfocus += 9;
            $this->fpdf->SetXY(6, $Yfocus);
            $this->fpdf->SetFont('Arial', '', 8);
            $this->fpdf->Cell(50, 5, 'Note: Pembayaran dengan Giro/Cheque/Transfer dianggap sah apabila dan sudah masuk ke rekening kami', 0, 0, 'L');
        }

        $this->fpdf->Output('delivery documents ' . $doc . '.pdf', 'I');
        exit;
    }

    function numberToSentence($nilai)
    {
        $nilai = abs($nilai);
        $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->numberToSentence($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->numberToSentence($nilai / 10) . " puluh" . $this->numberToSentence($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->numberToSentence($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->numberToSentence($nilai / 100) . " ratus" . $this->numberToSentence($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->numberToSentence($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->numberToSentence($nilai / 1000) . " ribu" . $this->numberToSentence($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->numberToSentence($nilai / 1000000) . " juta" . $this->numberToSentence($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->numberToSentence($nilai / 1000000000) . " milyar" . $this->numberToSentence(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->numberToSentence($nilai / 1000000000000) . " trilyun" . $this->numberToSentence(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    function formDriverAssignment()
    {
        return view(
            'transaction.delivery_assignment',
            ['PICs' => User::select('nick_name', 'name')
                ->where('branch', Auth::user()->branch)
                ->whereIn('role', ['driver', 'mechanic', 'operator'])
                ->get()]
        );
    }

    function emptyDriver(Request $request)
    {
        $data = T_DLVORDHEAD::on($this->dedicatedConnection)->select('MCUS_CUSNM', 'TDLVORD_DLVCD', 'TDLVORD_BRANCH', 'T_DLVORDHEAD.created_at', 'MCUS_ADDR1')
            ->leftJoin('M_CUS', function ($join) {
                $join->on('TDLVORD_CUSCD', '=', 'MCUS_CUSCD')->on('TDLVORD_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->whereNull('TDLVORD_DELIVERED_BY')
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->get();

        return ['data' => $data];
    }

    function assignDriver(Request $request)
    {
        $DOCNUM = base64_decode($request->id);
        # data quotation header
        $validator = Validator::make($request->all(), [
            'TDLVORD_JALAN_COST' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $SPK = C_SPK::on($this->dedicatedConnection)->select('CSPK_PIC_NAME')
            ->where('CSPK_REFF_DOC', $DOCNUM)
            ->where('CSPK_PIC_AS', 'DRIVER')
            ->first();

        $affectedRow = T_DLVORDHEAD::on($this->dedicatedConnection)
            ->where('TDLVORD_DLVCD', $DOCNUM)
            ->where('TDLVORD_BRANCH', $request->TDLVORD_BRANCH)
            ->update([
                'TDLVORD_DELIVERED_BY' => $SPK ? $SPK->CSPK_PIC_NAME : NULL,
                'TDLVORD_MEKANIK' => $request->TDLVORD_MEKANIK,
                'TDLVORD_JALAN_COST' => $request->TDLVORD_JALAN_COST,
                'TDLVORD_VEHICLE_REGNUM' => $request->TDLVORD_VEHICLE_REGNUM,
            ]);
        $message = $affectedRow ? 'Assigned' : 'Something wrong please contact admin';
        return ['message' => $message];
    }

    function confirmDelivery(Request $request)
    {
        $affectedRow = T_DLVORDHEAD::on($this->dedicatedConnection)
            ->where('TDLVORD_DLVCD', base64_decode($request->id))
            ->where('TDLVORD_BRANCH', $request->TDLVORD_BRANCH)
            ->where('TDLVORD_DELIVERED_BY', Auth::user()->nick_name)
            ->update([
                'TDLVORD_DELIVERED_AT' => date('Y-m-d H:i:s')
            ]);
        $message = $affectedRow ? 'Assigned' : 'Something wrong please contact admin';
        return ['message' => $message];
    }

    function deleteSPK(Request $request)
    {
        $affectedRow = C_SPK::on($this->dedicatedConnection)
            ->where('id', base64_decode($request->id))
            ->whereNull('deleted_at')
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => Auth::user()->nick_name
            ]);
        $message = $affectedRow ? 'Deleted' : 'Something wrong please contact admin';
        return ['message' => $message];
    }

    function formDeliveryConfirmation()
    {
        return view(
            'transaction.delivery_confirmation'
        );
    }

    function emptyDeliveryDateTime(Request $request)
    {
        $data = T_DLVORDHEAD::on($this->dedicatedConnection)->select('MCUS_CUSNM', 'MCUS_ADDR1', 'TDLVORD_DLVCD', 'TDLVORD_BRANCH', 'T_DLVORDHEAD.created_at')
            ->leftJoin('M_CUS', function ($join) {
                $join->on('TDLVORD_CUSCD', '=', 'MCUS_CUSCD')->on('TDLVORD_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->whereNull('TDLVORD_DELIVERED_AT')
            ->where('TDLVORD_DELIVERED_BY', Auth::user()->nick_name)
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->get();
        return ['data' => $data];
    }

    function emptyOutgoingConfirmation()
    {
        $RSDeliverySub = T_DLVORDDETA::select('TDLVORDDETA_DLVCD', 'TDLVORDDETA_BRANCH', DB::raw('COUNT(*) TTLROW'))
            ->whereNull('deleted_at')
            ->where('TDLVORDDETA_BRANCH', Auth::user()->branch)
            ->groupBy('TDLVORDDETA_DLVCD', 'TDLVORDDETA_BRANCH');
        $RSITRN = C_ITRN::select('CITRN_BRANCH', 'CITRN_DOCNO')
            ->whereNull('deleted_at')
            ->groupBy('CITRN_DOCNO')
            ->where('CITRN_BRANCH', Auth::user()->branch)
            ->groupBy('CITRN_BRANCH', 'CITRN_DOCNO');
        $RSDelivery = T_DLVORDHEAD::on($this->dedicatedConnection)
            ->leftJoin('M_CUS', function ($join) {
                $join->on('TDLVORD_CUSCD', '=', 'MCUS_CUSCD')->on('TDLVORD_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->leftJoinSub($RSDeliverySub, 'V1', function ($join) {
                $join->on('TDLVORD_BRANCH', '=', 'TDLVORDDETA_BRANCH')
                    ->on('TDLVORD_DLVCD', '=', 'TDLVORDDETA_DLVCD');
            })
            ->leftJoin($RSITRN, 'V2', function ($join) {
                $join->on('TDLVORD_BRANCH', '=', 'CITRN_BRANCH')
                    ->on('TDLVORD_DLVCD', '=', 'CITRN_DOCNO');
            })
            ->select('MCUS_CUSNM', 'TDLVORD_DLVCD')
            ->whereRaw('IFNULL(TTLROW,0)>0')
            ->whereNull('CITRN_DOCNO');
        return ['data' => $RSDelivery->get()];
    }

    public function saveSPK(Request $request)
    {
        # Validasi General
        $validator = Validator::make($request->all(), [
            'CSPK_REFF_DOC' => 'required',
            'CSPK_PIC_AS' => 'required',
            'CSPK_PIC_NAME' => 'required',
            'CSPK_JOBDESK' => 'required',
            'CSPK_BACKDT' => 'required',
            'CSPK_LEAVEDT' => 'required',
            'CSPK_UANG_MAKAN' => 'required|numeric',
            'CSPK_UANG_MANDAH' => 'required|numeric',
            'CSPK_UANG_PENGINAPAN' => 'required|numeric',
            'CSPK_UANG_PENGAWALAN' => 'required|numeric',
            'CSPK_UANG_LAIN2' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $RangePrice = NULL;

        # Validasi Driver
        $UANG_JALAN = 0;
        if ($request->CSPK_PIC_AS === 'DRIVER') {
            $RangePrice = M_DISTANCE_PRICE::on($this->dedicatedConnection)->select('*')
                ->where('RANGE2', '>=', $request->CSPK_KM)
                ->where('BRANCH', Auth::user()->branch)
                ->orderBy('RANGE1', 'ASC')
                ->first();
            if (!$RangePrice) {
                return response()->json([['Distance out of range, please register on distance price master']], 406);
            }

            $validator = Validator::make($request->all(), [
                'CSPK_VEHICLE_TYPE' => 'required',
                'CSPK_VEHICLE_REGNUM' => 'required',
                'CSPK_KM' => 'required|numeric',
                'CSPK_WHEELS' => 'required|numeric',
                'CSPK_SUPPLIER' => 'required',
                'CSPK_LITER' => 'required|numeric',
                'CSPK_LITER_EXISTING' => 'required|numeric',
            ]);

            $UANG_JALAN = $request->CSPK_WHEELS == 10 ? $RangePrice->PRICE_WHEEL_10 : $RangePrice->PRICE_WHEEL_4_AND_6;

            if ($validator->fails()) {
                return response()->json($validator->errors(), 406);
            }
        }

        $LastLine = DB::connection($this->dedicatedConnection)->table('C_SPK')
            ->whereYear('created_at', '=', date('Y'))
            ->where('CSPK_BRANCH', Auth::user()->branch)
            ->max('CSPK_DOCNO_ORDER');
        $newDocCode = '';
        if (!$LastLine) {
            $LastLine = 1;
            $newDocCode = date('Y') . '-00001';
        } else {
            $LastLine++;
            $newDocCode = date('Y') . '-' . substr('0000' . $LastLine, -5);
        }
        $PreparedData = [
            'CSPK_REFF_DOC' => $request->CSPK_REFF_DOC,
            'CSPK_PIC_AS' => $request->CSPK_PIC_AS,
            'CSPK_PIC_NAME' => $request->CSPK_PIC_NAME,
            'CSPK_KM' => $request->CSPK_KM ?? 0,
            'CSPK_WHEELS' => $request->CSPK_WHEELS,
            'CSPK_UANG_JALAN' => $UANG_JALAN,
            'CSPK_SUPPLIER' => $request->CSPK_SUPPLIER,
            'CSPK_LITER_EXISTING' => $request->CSPK_LITER_EXISTING ? $request->CSPK_LITER_EXISTING : 0,
            'CSPK_LITER' => $request->CSPK_LITER ? $request->CSPK_LITER : 0,
            'CSPK_UANG_SOLAR' => $request->CSPK_SUPPLIER == 'SPBU' ? 6800 * $request->CSPK_LITER : 0 * $request->CSPK_LITER,
            'CSPK_UANG_MAKAN' => $request->CSPK_UANG_MAKAN,
            'CSPK_UANG_MANDAH' => $request->CSPK_UANG_MANDAH,
            'CSPK_UANG_PENGINAPAN' => $request->CSPK_UANG_PENGINAPAN,
            'CSPK_UANG_PENGAWALAN' => $request->CSPK_UANG_PENGAWALAN,
            'CSPK_UANG_LAIN2' => $request->CSPK_UANG_LAIN2,
            'CSPK_BRANCH' => Auth::user()->branch,
            'created_by' => Auth::user()->nick_name,
            'CSPK_LEAVEDT' => $request->CSPK_LEAVEDT,
            'CSPK_BACKDT' => $request->CSPK_BACKDT,
            'CSPK_VEHICLE_TYPE' => $request->CSPK_VEHICLE_TYPE ?? '',
            'CSPK_VEHICLE_REGNUM' => $request->CSPK_VEHICLE_REGNUM ? $request->CSPK_VEHICLE_REGNUM : '',
            'CSPK_JOBDESK' => $request->CSPK_JOBDESK,
            'CSPK_DOCNO' => $newDocCode,
            'CSPK_DOCNO_ORDER' => $LastLine,
        ];
        $responseOfCreate = C_SPK::on($this->dedicatedConnection)->create($PreparedData);
        return ['message' => 'OK', 'data' => $RangePrice];
    }

    public function getSPKByDO(Request $request)
    {
        $SPKs = C_SPK::on($this->dedicatedConnection)->where('CSPK_REFF_DOC', base64_decode($request->id))->get();
        return ['data' => $SPKs];
    }

    function autoPurchaseToSparepart($ParamData)
    {
        # Periksa apakah sparepart sudah diregistrasi sebagai supplier
        $Supplier = M_SUP::on($this->dedicatedConnection)
            ->where('MSUP_CGCON', 'connect_jos_service')
            ->where('MSUP_BRANCH', Auth::user()->branch)
            ->first();

        if (!empty($Supplier)) {

            if (
                T_PCHORDHEAD::on($this->dedicatedConnection)
                ->where('TPCHORD_BRANCH', Auth::user()->branch)
                ->where('TPCHORD_REMARK', $ParamData['DOC'])->count() > 0
            ) {
                return true;
            }

            # Generate Nomor PO
            $RSAlias = CompanyGroup::select('alias_code')
                ->where('connection', $this->dedicatedConnection)
                ->first();

            $LastLine = DB::connection($this->dedicatedConnection)->table('T_PCHORDHEAD')
                ->whereMonth('created_at', '=', date('m'))
                ->whereYear('created_at', '=', date('Y'))
                ->whereYear('TPCHORD_BRANCH', '=', Auth::user()->branch)
                ->max('TPCHORD_LINE');

            $newPOCode = '';
            if (!$LastLine) {
                $LastLine = 1;
                $newPOCode = '001/' . $RSAlias->alias_code . '-PO/' . $this->monthOfRoma[date('n') - 1] . '/' . date('y');
            } else {
                $LastLine++;
                $newPOCode = substr('00' . $LastLine, -3) . '/' . $RSAlias->alias_code . '-PO/' . $this->monthOfRoma[date('n') - 1] . '/' . date('y');
            }

            $headerTable = [
                'TPCHORD_PCHCD' => $newPOCode,
                'TPCHORD_ATTN' => '-',
                'TPCHORD_SUPCD' => $Supplier->MSUP_SUPCD,
                'TPCHORD_LINE' => $LastLine,
                'TPCHORD_ISSUDT' => date('Y-m-d'),
                'TPCHORD_APPRVBY' => Auth::user()->nick_name,
                'TPCHORD_APPRVDT' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->nick_name,
                'TPCHORD_BRANCH' => Auth::user()->branch,
                'TPCHORD_REMARK' => $ParamData['DOC'],
                'TPCHORD_REQCD' => '',
            ];

            $detailTable = [];

            $detailTable[] = [
                'TPCHORDDETA_PCHCD' => $newPOCode,
                'TPCHORDDETA_ITMCD' => 'SOLAR',
                'TPCHORDDETA_ITMQT' => $ParamData['QTY'],
                'TPCHORDDETA_ITMPRC_PER' => 0,
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
                'TPCHORDDETA_BRANCH' => Auth::user()->branch,
            ];

            # Simpan data ke Tabel PO Header
            T_PCHORDHEAD::on($this->dedicatedConnection)->create($headerTable);

            # Simpan data ke Tabel PO Detail
            T_PCHORDDETA::on($this->dedicatedConnection)->insert($detailTable);

            return true;
        } else {
            return false;
        }
    }

    function SPKtoPDF(Request $request)
    {
        $doc = base64_decode($request->id);
        $Data = C_SPK::on($this->dedicatedConnection)->where('id', $doc)->first();

        if (empty($Data)) {
            return 'something wrong happen';
        }

        if (!$Data->CSPK_GA_MGR_APPROVED_BY) {
            return ['message' => 'GA Manager Approval is required'];
        }

        $PICMenugaskan = User::where('nick_name', $Data->created_by)->first();
        $PICDitugaskan = User::where('nick_name', $Data->CSPK_PIC_NAME)->first();

        $Tujuan = T_DLVORDDETA::on($this->dedicatedConnection)
            ->leftJoin('T_SLOHEAD', function ($join) {
                $join->on('TDLVORDDETA_SLOCD', '=', 'TSLO_SLOCD')->on('TDLVORDDETA_BRANCH', '=', 'TSLO_BRANCH');
            })->where('TDLVORDDETA_DLVCD', $Data->CSPK_REFF_DOC)
            ->where('TDLVORDDETA_BRANCH', Auth::user()->branch)
            ->select('TSLO_ADDRESS_NAME', 'TSLO_ADDRESS_DESCRIPTION')->first();

        $this->fpdf->AddPage("P", 'A5');
        $this->fpdf->SetAutoPageBreak(true, 0);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->SetXY(3, 5);
        $this->fpdf->Cell(45, 5, 'SPK DELIVERY BARANG', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(3, 20);
        $this->fpdf->Cell(45, 5, 'ID SPK', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Data->CSPK_DOCNO, 0, 0, 'L');
        $this->fpdf->SetXY(3, 25);
        $this->fpdf->Cell(45, 5, 'Tanggal', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . date('Y-m-d'), 0, 0, 'L');
        $this->fpdf->SetXY(3, 30);
        $this->fpdf->Cell(45, 5, 'PIC Yang Menugaskan', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $PICMenugaskan->name, 0, 0, 'L');
        $this->fpdf->SetXY(3, 35);
        $this->fpdf->Cell(45, 5, 'PIC Yang Ditugaskan', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $PICDitugaskan->name, 0, 0, 'L');
        $this->fpdf->SetXY(3, 40);
        $this->fpdf->Cell(45, 5, 'Posisi', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Data->CSPK_PIC_AS, 0, 0, 'L');
        $this->fpdf->SetXY(3, 45);
        $this->fpdf->Cell(45, 5, 'Tujuan', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Tujuan->TSLO_ADDRESS_NAME, 0, 0, 'L');
        $this->fpdf->SetXY(3, 50);
        $this->fpdf->Cell(45, 5, '', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Tujuan->TSLO_ADDRESS_DESCRIPTION, 0, 0, 'L');


        $this->fpdf->SetXY(3, 60);
        $this->fpdf->Cell(45, 5, 'Tanggal Berangkat', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Data->CSPK_LEAVEDT . ' s/d ' . $Data->CSPK_BACKDT, 0, 0, 'L');
        $this->fpdf->SetXY(3, 65);
        $this->fpdf->Cell(45, 5, 'Jenis Kendaraan', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Data->CSPK_VEHICLE_TYPE, 0, 0, 'L');
        $this->fpdf->SetXY(3, 70);
        $this->fpdf->Cell(45, 5, 'Nomor Referensi', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Data->CSPK_REFF_DOC, 0, 0, 'L');
        $this->fpdf->SetXY(3, 75);
        $this->fpdf->Cell(45, 5, 'Tugas', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Data->CSPK_JOBDESK, 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(3, 85);
        $this->fpdf->Cell(45, 5, 'Biaya', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(3, 90);
        $this->fpdf->Cell(10, 5, 'No', 1, 0, 'C');
        $this->fpdf->Cell(75, 5, 'Item', 1, 0, 'C');
        $this->fpdf->Cell(50, 5, 'Jumlah', 1, 0, 'C');
        $this->fpdf->SetFont('Arial', '', 10);
        $TotalPrice = $Data->CSPK_UANG_JALAN + $Data->CSPK_UANG_SOLAR + $Data->CSPK_UANG_MAKAN
            + $Data->CSPK_UANG_MANDAH + $Data->CSPK_UANG_PENGINAPAN + $Data->CSPK_UANG_PENGAWALAN
            + $Data->CSPK_UANG_LAIN2;
        if ($Data->CSPK_PIC_AS === 'DRIVER') {
            if ($Data->CSPK_SUPPLIER !== 'SPBU') {
                $resultPurchase = $this->autoPurchaseToSparepart(['QTY' => $Data->CSPK_LITER, 'DOC' => $Data->CSPK_DOCNO]);
            }
            $this->fpdf->SetXY(3, 95);
            $this->fpdf->Cell(10, 5, '1', 1, 0, 'C');
            $this->fpdf->Cell(75, 5, 'Total', 1, 0, 'C');
            $this->fpdf->Cell(50, 5, number_format($TotalPrice), 1, 0, 'C');
            $this->fpdf->SetXY(3, 105);
            $this->fpdf->Cell(10, 5, 'Terbilang', 0, 0, 'L');
            $this->fpdf->SetXY(3, 110);
            $this->fpdf->MultiCell(140, 5, ucwords(trim($this->numberToSentence($TotalPrice))), 1, 'C');
            $this->fpdf->SetXY(3, 120);
            $this->fpdf->Cell(10, 5, 'PIC yang ditugaskan', 0, 0, 'L');
            $this->fpdf->SetXY(100, 120);
            $this->fpdf->Cell(10, 5, 'PIC yang menugaskan', 0, 0, 'L');

            $this->fpdf->SetXY(3, 155);
            $this->fpdf->Cell(10, 5, ucwords($PICDitugaskan->name) . ' - ' . $Data->CSPK_PIC_AS, 0, 0, 'L');
            $this->fpdf->SetXY(100, 155);
            $this->fpdf->Cell(10, 5, ucwords($PICMenugaskan->name), 0, 0, 'L');
        } else {
            $this->fpdf->SetXY(3, 95);
            $this->fpdf->Cell(10, 5, '1', 1, 0, 'C');
            $this->fpdf->Cell(75, 5, 'Uang Jalan', 1, 0, 'C');
            $this->fpdf->Cell(50, 5, number_format($Data->CSPK_UANG_JALAN), 1, 0, 'R');
            $this->fpdf->SetXY(3, 100);
            $this->fpdf->Cell(10, 5, '2', 1, 0, 'C');
            $this->fpdf->Cell(75, 5, 'Uang Solar', 1, 0, 'C');
            $this->fpdf->Cell(50, 5, number_format($Data->CSPK_UANG_SOLAR), 1, 0, 'R');
            $this->fpdf->SetXY(3, 105);
            $this->fpdf->Cell(10, 5, '3', 1, 0, 'C');
            $this->fpdf->Cell(75, 5, 'Uang Makan', 1, 0, 'C');
            $this->fpdf->Cell(50, 5, number_format($Data->CSPK_UANG_MAKAN), 1, 0, 'R');
            $this->fpdf->SetXY(3, 110);
            $this->fpdf->Cell(10, 5, '4', 1, 0, 'C');
            $this->fpdf->Cell(75, 5, 'Uang Mandah', 1, 0, 'C');
            $this->fpdf->Cell(50, 5, number_format($Data->CSPK_UANG_MANDAH), 1, 0, 'R');
            $this->fpdf->SetXY(3, 115);
            $this->fpdf->Cell(10, 5, '5', 1, 0, 'C');
            $this->fpdf->Cell(75, 5, 'Uang Penginapan', 1, 0, 'C');
            $this->fpdf->Cell(50, 5, number_format($Data->CSPK_UANG_PENGINAPAN), 1, 0, 'R');
            $this->fpdf->SetXY(3, 120);
            $this->fpdf->Cell(10, 5, '6', 1, 0, 'C');
            $this->fpdf->Cell(75, 5, 'Uang Pengawalan', 1, 0, 'C');
            $this->fpdf->Cell(50, 5, number_format($Data->CSPK_UANG_PENGAWALAN), 1, 0, 'R');
            $this->fpdf->SetXY(3, 125);
            $this->fpdf->Cell(10, 5, '7', 1, 0, 'C');
            $this->fpdf->Cell(75, 5, 'Uang lain - lain', 1, 0, 'C');
            $this->fpdf->Cell(50, 5, number_format($Data->CSPK_UANG_LAIN2), 1, 0, 'R');
            $this->fpdf->SetXY(3, 130);
            $this->fpdf->Cell(10, 5, '', 0, 0, 'C');
            $this->fpdf->Cell(75, 5, 'Total', 0, 0, 'R');
            $this->fpdf->Cell(50, 5, number_format($TotalPrice), 1, 0, 'R');
            $this->fpdf->SetXY(3, 140);
            $this->fpdf->Cell(10, 5, 'Terbilang', 0, 0, 'L');
            $this->fpdf->SetXY(3, 145);
            $this->fpdf->MultiCell(140, 5, ucwords(trim($this->numberToSentence($TotalPrice))), 1, 'C');

            $this->fpdf->SetXY(3, 155);
            $this->fpdf->Cell(10, 5, 'PIC yang ditugaskan', 0, 0, 'L');
            $this->fpdf->SetXY(100, 155);
            $this->fpdf->Cell(10, 5, 'PIC yang menugaskan', 0, 0, 'L');
        }


        $this->fpdf->AddPage("P", 'A5');
        $this->fpdf->SetAutoPageBreak(true, 0);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->SetXY(3, 5);
        $this->fpdf->Cell(45, 5, 'REALISASI DELIVERY BARANG', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(3, 20);
        $this->fpdf->Cell(45, 5, 'ID SPK', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Data->CSPK_DOCNO, 0, 0, 'L');
        $this->fpdf->SetXY(3, 25);
        $this->fpdf->Cell(45, 5, 'Tanggal', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . date('Y-m-d'), 0, 0, 'L');
        $this->fpdf->SetXY(3, 30);
        $this->fpdf->Cell(45, 5, 'PIC Yang Menugaskan', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $PICMenugaskan->name, 0, 0, 'L');
        $this->fpdf->SetXY(3, 35);
        $this->fpdf->Cell(45, 5, 'PIC Yang Ditugaskan', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $PICDitugaskan->name, 0, 0, 'L');
        $this->fpdf->SetXY(3, 40);
        $this->fpdf->Cell(45, 5, 'Posisi', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Data->CSPK_PIC_AS, 0, 0, 'L');
        $this->fpdf->SetXY(3, 45);
        $this->fpdf->Cell(45, 5, 'Tujuan', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Tujuan->TSLO_ADDRESS_NAME, 0, 0, 'L');
        $this->fpdf->SetXY(3, 50);
        $this->fpdf->Cell(45, 5, '', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Tujuan->TSLO_ADDRESS_DESCRIPTION, 0, 0, 'L');


        $this->fpdf->SetXY(3, 60);
        $this->fpdf->Cell(45, 5, 'Tanggal Berangkat', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Data->CSPK_LEAVEDT . ' s/d ' . $Data->CSPK_BACKDT, 0, 0, 'L');
        $this->fpdf->SetXY(3, 65);
        $this->fpdf->Cell(45, 5, 'Jenis Kendaraan', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Data->CSPK_VEHICLE_TYPE, 0, 0, 'L');
        $this->fpdf->SetXY(3, 70);
        $this->fpdf->Cell(45, 5, 'Nomor Referensi', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Data->CSPK_REFF_DOC, 0, 0, 'L');
        $this->fpdf->SetXY(3, 75);
        $this->fpdf->Cell(45, 5, 'Tugas', 0, 0, 'L');
        $this->fpdf->Cell(45, 5, ': ' . $Data->CSPK_JOBDESK, 0, 0, 'L');

        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(3, 85);
        $this->fpdf->Cell(45, 5, 'Biaya', 0, 0, 'L');
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(3, 90);
        $this->fpdf->Cell(10, 5, 'No', 1, 0, 'C');
        $this->fpdf->Cell(58, 5, 'Item', 1, 0, 'C');
        $this->fpdf->Cell(40, 5, 'Jumlah Diserahkan', 1, 0, 'C');
        $this->fpdf->Cell(30, 5, 'Jumlah Aktual', 1, 0, 'C');
        $this->fpdf->SetFont('Arial', '', 10);

        $this->fpdf->SetXY(3, 95);
        $this->fpdf->Cell(10, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(58, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(40, 5, '', 1, 0, 'R');
        $this->fpdf->Cell(30, 5, '', 1, 0, 'R');
        $this->fpdf->SetXY(3, 100);
        $this->fpdf->Cell(10, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(58, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(40, 5, '', 1, 0, 'R');
        $this->fpdf->Cell(30, 5, '', 1, 0, 'R');
        $this->fpdf->SetXY(3, 105);
        $this->fpdf->Cell(10, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(58, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(40, 5, '', 1, 0, 'R');
        $this->fpdf->Cell(30, 5, '', 1, 0, 'R');
        $this->fpdf->SetXY(3, 110);
        $this->fpdf->Cell(10, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(58, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(40, 5, '', 1, 0, 'R');
        $this->fpdf->Cell(30, 5, '', 1, 0, 'R');
        $this->fpdf->SetXY(3, 115);
        $this->fpdf->Cell(10, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(58, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(40, 5, '', 1, 0, 'R');
        $this->fpdf->Cell(30, 5, '', 1, 0, 'R');
        $this->fpdf->SetXY(3, 120);
        $this->fpdf->Cell(10, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(58, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(40, 5, '', 1, 0, 'R');
        $this->fpdf->Cell(30, 5, '', 1, 0, 'R');
        $this->fpdf->SetXY(3, 125);
        $this->fpdf->Cell(10, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(58, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(40, 5, '', 1, 0, 'R');
        $this->fpdf->Cell(30, 5, '', 1, 0, 'R');
        $this->fpdf->SetXY(3, 130);
        $this->fpdf->Cell(10, 5, '', 1, 0, 'C');
        $this->fpdf->Cell(58, 5, '', 1, 0, 'R');
        $this->fpdf->Cell(40, 5, '', 1, 0, 'R');
        $this->fpdf->Cell(30, 5, '', 1, 0, 'R');
        $this->fpdf->SetXY(3, 135);
        $this->fpdf->Cell(10, 5, '', 0, 0, 'C');
        $this->fpdf->Cell(58, 5, 'Total', 0, 0, 'R');
        $this->fpdf->Cell(40, 5, '', 1, 0, 'R');
        $this->fpdf->Cell(30, 5, '', 1, 0, 'R');
        $this->fpdf->SetXY(3, 140);
        $this->fpdf->Cell(10, 5, '', 0, 0, 'C');
        $this->fpdf->Cell(58, 5, 'Selisih', 0, 0, 'R');
        $this->fpdf->Cell(40, 5, '', 0, 0, 'R');
        $this->fpdf->Cell(30, 5, '', 1, 0, 'R');
        $this->fpdf->SetXY(3, 150);
        $this->fpdf->Cell(10, 5, 'Terbilang selisih', 0, 0, 'L');
        $this->fpdf->SetXY(3, 155);
        $this->fpdf->MultiCell(140, 5, '', 1, 'C');

        $this->fpdf->SetXY(3, 165);
        $this->fpdf->Cell(10, 5, 'PIC yang ditugaskan', 0, 0, 'L');
        $this->fpdf->SetXY(100, 165);
        $this->fpdf->Cell(10, 5, 'PIC yang menugaskan', 0, 0, 'L');

        $this->fpdf->SetXY(3, 190);
        $this->fpdf->Cell(10, 5, ucwords($PICDitugaskan->name) . ' - ' . $Data->CSPK_PIC_AS, 0, 0, 'L');
        $this->fpdf->SetXY(100, 190);
        $this->fpdf->Cell(10, 5, ucwords($PICMenugaskan->name), 0, 0, 'L');

        $this->fpdf->Output('SPK ' . $doc . '.pdf', 'I');
        exit;
    }

    function submitSPK(Request $request)
    {
        $affectedRow = C_SPK::on($this->dedicatedConnection)
            ->where('id', base64_decode($request->id))
            ->update([
                'submitted_by' => Auth::user()->nick_name,
                'submitted_at' => date('Y-m-d H:i:s')
            ]);

        if ($affectedRow) {
            ApprovalHistory::on($this->dedicatedConnection)->create([
                'created_by' => Auth::user()->nick_name,
                'form' => 'SPK',
                'code' => base64_decode($request->id),
                'type' => '1',
                'remark' => '',
                'branch' => Auth::user()->branch,
            ]);
        }
        return ['message' => 'Submitted'];
    }

    function formApprovalSPK()
    {
        return view('transaction.spk_approval');
    }

    function notificationsSPK()
    {
        $currentDBName = DB::getDatabaseName();

        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        $SPK = C_SPK::on($this->dedicatedConnection)->selectRaw('C_SPK.*, A.name AS USER_PIC_NAME')
            ->leftJoin($currentDBName . '.users AS A', 'C_SPK.CSPK_PIC_NAME', '=', 'A.nick_name')
            ->whereNotNull('submitted_at');
        if ($activeRole['code'] === 'ga_manager') {
            $SPK->whereNull('CSPK_GA_MGR_APPROVED_AT');
        }
        if ($activeRole['code'] === 'ga_spv') {
            $SPK->whereNull('CSPK_GA_SPV_APPROVED_AT');
        }
        $UnApprovedSPK = $SPK->get();
        $UnApprovedSPK = json_decode(json_encode($UnApprovedSPK), true);

        $data = [];

        $ArrayUniqueDO = [];
        foreach ($UnApprovedSPK as $r) {
            if (!in_array($r['CSPK_REFF_DOC'], $ArrayUniqueDO)) {
                $ArrayUniqueDO[] = $r['CSPK_REFF_DOC'];
            }
        }

        $data = T_DLVORDHEAD::on($this->dedicatedConnection)
            ->select('MCUS_CUSNM', 'TDLVORD_DLVCD', 'TDLVORD_BRANCH', 'T_DLVORDHEAD.created_at', 'MCUS_ADDR1')
            ->leftJoin('M_CUS', function ($join) {
                $join->on('TDLVORD_CUSCD', '=', 'MCUS_CUSCD')->on('TDLVORD_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->whereIn('TDLVORD_DLVCD', $ArrayUniqueDO)
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->get();

        foreach ($UnApprovedSPK as &$r) {
            foreach ($data as $d) {
                if ($r['CSPK_REFF_DOC'] === $d['TDLVORD_DLVCD']) {
                    $r['MCUS_CUSNM'] = $d['MCUS_CUSNM'];
                    $r['MCUS_ADDR1'] = $d['MCUS_ADDR1'];
                    break;
                }
            }
        }
        unset($r);

        return ['data' => $UnApprovedSPK];
    }

    public function approveSPK(Request $request)
    {
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        $ColumnFocusName = '';
        $ColumnFocusTime = '';
        switch ($activeRole['code']) {
            case 'ga_manager':
                $ColumnFocusName = 'CSPK_GA_MGR_APPROVED_BY';
                $ColumnFocusTime = 'CSPK_GA_MGR_APPROVED_AT';
                break;
            case 'ga_spv':
                $ColumnFocusName = 'CSPK_GA_SPV_APPROVED_BY';
                $ColumnFocusTime = 'CSPK_GA_SPV_APPROVED_AT';
                break;
        }
        # ubah data header
        $affectedRow = C_SPK::on($this->dedicatedConnection)
            ->where('id', $request->id)
            ->update([
                $ColumnFocusName => Auth::user()->nick_name,
                $ColumnFocusTime => date('Y-m-d H:i:s')
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    function searchSPK(Request $request)
    {
        $currentDBName = DB::getDatabaseName();
        $columnMap = [
            'CSPK_DOCNO',
            'A.name',
        ];
        $RS = C_SPK::on($this->dedicatedConnection)->select([
            "CSPK_DOCNO",
            DB::raw("A.name AS USER_PIC_NAME"),
            DB::raw("CSPK_UANG_JALAN + CSPK_UANG_SOLAR + CSPK_UANG_MAKAN
            + CSPK_UANG_MANDAH + CSPK_UANG_PENGINAPAN + CSPK_UANG_PENGAWALAN
            + CSPK_UANG_LAIN2 AS TOTAL_AMOUNT")
        ])
            ->leftJoin($currentDBName . '.users AS A', 'C_SPK.CSPK_PIC_NAME', '=', 'A.nick_name')
            ->where('CSPK_BRANCH', Auth::user()->branch)
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->get();
        return ['data' => $RS];
    }

    function formUnconfirmed()
    {
        return view(
            'transaction.outgoing_confirmation'
        );
    }

    function unconfirmed()
    {
        $Delivery = T_DLVORDHEAD::on($this->dedicatedConnection)
            ->leftJoin('T_DLVORDDETA', function ($join) {
                $join->on('TDLVORD_DLVCD', '=', 'TDLVORDDETA_DLVCD')->on('TDLVORD_BRANCH', '=', 'TDLVORDDETA_BRANCH');
            })
            ->leftJoin('M_CUS', function ($join) {
                $join->on('TDLVORD_CUSCD', '=', 'MCUS_CUSCD')->on('TDLVORD_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->leftJoin('M_ITM', function ($join) {
                $join->on('TDLVORDDETA_ITMCD', '=', 'MITM_ITMCD');
            })
            ->select('TDLVORD_DLVCD', 'TDLVORD_BRANCH', 'MCUS_CUSNM')
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->whereNull('T_DLVORDDETA.deleted_at')
            ->where('MITM_ITMTYPE', '!=', '3')
            ->groupBy('TDLVORD_DLVCD', 'TDLVORD_BRANCH', 'MCUS_CUSNM');

        $ITRN = C_ITRN::on($this->dedicatedConnection)
            ->select('CITRN_DOCNO', 'CITRN_BRANCH')
            ->where('CITRN_BRANCH', Auth::user()->branch)
            ->groupBy('CITRN_DOCNO', 'CITRN_BRANCH');

        $Data = DB::connection($this->dedicatedConnection)->query()->fromSub($Delivery, 'V1')
            ->leftJoinSub($ITRN, 'V2', function ($join) {
                $join->on('TDLVORD_DLVCD', '=', 'CITRN_DOCNO')->on('TDLVORD_BRANCH', '=', 'CITRN_BRANCH');
            })
            ->whereNull('CITRN_DOCNO');
        return ['data' => $Data->get(), 'sql' => $Data->toSql()];
    }

    function confirmOutgoing(Request $request)
    {
        $totalEmptyItemActual = T_DLVORDDETA::on($this->dedicatedConnection)
            ->whereNull('TDLVORDDETA_ITMCD_ACT')
            ->where('TDLVORDDETA_BRANCH', Auth::user()->branch)
            ->where('TDLVORDDETA_DLVCD', $request->id)
            ->count();
        if ($totalEmptyItemActual > 0) {
            return response()->json([['Please input Actual item']], 406);
        }

        $Delivery = T_DLVORDHEAD::on($this->dedicatedConnection)
            ->leftJoin('T_DLVORDDETA', function ($join) {
                $join->on('TDLVORD_DLVCD', '=', 'TDLVORDDETA_DLVCD')->on('TDLVORD_BRANCH', '=', 'TDLVORDDETA_BRANCH');
            })
            ->leftJoin('M_CUS', function ($join) {
                $join->on('TDLVORD_CUSCD', '=', 'MCUS_CUSCD')->on('TDLVORD_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->leftJoin('M_ITM', function ($join) {
                $join->on('TDLVORDDETA_ITMCD', '=', 'MITM_ITMCD');
            })
            ->select('TDLVORD_DLVCD', 'TDLVORD_BRANCH', 'MCUS_CUSNM')
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->where('TDLVORD_DLVCD', $request->id)
            ->whereNull('T_DLVORDDETA.deleted_at')
            ->where('MITM_ITMTYPE', '!=', '3')
            ->groupBy('TDLVORD_DLVCD', 'TDLVORD_BRANCH', 'MCUS_CUSNM');

        $ITRN = C_ITRN::on($this->dedicatedConnection)
            ->select('CITRN_DOCNO', 'CITRN_BRANCH')
            ->where('CITRN_BRANCH', Auth::user()->branch)
            ->where('CITRN_DOCNO', $request->id)
            ->groupBy('CITRN_DOCNO', 'CITRN_BRANCH');

        $Data = DB::connection($this->dedicatedConnection)->query()->fromSub($Delivery, 'V1')
            ->leftJoinSub($ITRN, 'V2', function ($join) {
                $join->on('TDLVORD_DLVCD', '=', 'CITRN_DOCNO')->on('TDLVORD_BRANCH', '=', 'CITRN_BRANCH');
            })
            ->whereNull('CITRN_DOCNO')->get();

        if (count($Data)) {
            $Delivery = T_DLVORDDETA::on($this->dedicatedConnection)
                ->select('TDLVORDDETA_ITMCD_ACT', 'TDLVORDDETA_ITMQT')
                ->where('TDLVORDDETA_DLVCD', $request->id)
                ->where('TDLVORDDETA_BRANCH', Auth::user()->branch)
                ->get();
            foreach ($Delivery as $r) {
                C_ITRN::on($this->dedicatedConnection)->create([
                    'CITRN_BRANCH' => Auth::user()->branch,
                    'CITRN_LOCCD' => 'WH1',
                    'CITRN_DOCNO' => $request->id,
                    'CITRN_ISSUDT' => date('Y-m-d'),
                    'CITRN_FORM' => 'OUT-SHP',
                    'CITRN_ITMCD' => $r->TDLVORDDETA_ITMCD_ACT,
                    'CITRN_ITMQT' => $r->TDLVORDDETA_ITMQT * -1,
                    'CITRN_PRCPER' => 0,
                    'CITRN_PRCAMT' => 0,
                    'created_by' => Auth::user()->nick_name,
                ]);
            }
        }

        return ['msg' => 'Confirmed !'];
    }

    function saveAccessory(Request $request)
    {
        # data quotation detail item
        $validator = Validator::make($request->all(), [
            'TDLVACCESSORY_DLVCD' => 'required',
            'TDLVACCESSORY_ITMCD' => 'required',
            'TDLVACCESSORY_ITMQT' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        T_DLVACCESSORY::on($this->dedicatedConnection)->create([
            'TDLVACCESSORY_DLVCD' => base64_decode($request->id),
            'TDLVACCESSORY_ITMCD' => $request->TDLVACCESSORY_ITMCD,
            'TDLVACCESSORY_ITMQT' => $request->TDLVACCESSORY_ITMQT,
            'created_by' => Auth::user()->nick_name,
            'TDLVACCESSORY_BRANCH' => Auth::user()->branch
        ]);

        return [
            'message' => 'OK.'
        ];
    }

    function loadAccessoryById(Request $request)
    {
        $data = T_DLVACCESSORY::on($this->dedicatedConnection)
            ->leftJoin('M_ITM', function ($join) {
                $join->on('TDLVACCESSORY_ITMCD', '=', 'MITM_ITMCD')->on('TDLVACCESSORY_BRANCH', '=', 'MITM_BRANCH');
            })
            ->select('id', 'MITM_ITMCD', 'TDLVACCESSORY_ITMQT', 'MITM_ITMNM')
            ->where('TDLVACCESSORY_DLVCD', base64_decode($request->id))
            ->where('TDLVACCESSORY_BRANCH', Auth::user()->branch)
            ->whereNull('deleted_at')
            ->get();
        return ['data' => $data];
    }

    function deleteAccessoryById(Request $request)
    {
        $affectedRow = T_DLVACCESSORY::on($this->dedicatedConnection)->where('id', $request->id)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::user()->nick_name
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'could not be deleted', 'affectedRow' => $affectedRow];
    }

    function updateAccessoryById(Request $request)
    {
        $affectedRow = T_DLVACCESSORY::on($this->dedicatedConnection)->where('id', $request->id)
            ->update([
                'TDLVACCESSORY_ITMCD' => $request->TDLVACCESSORY_ITMCD,
                'TDLVACCESSORY_ITMQT' => $request->TDLVACCESSORY_ITMQT,
                'updated_by' => Auth::user()->nick_name
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'could not be deleted', 'affectedRow' => $affectedRow];
    }

    function unreturnedItem()
    {
        $data = C_ITRN::on($this->dedicatedConnection)
            ->leftJoin('T_DLVORDDETA', function ($join) {
                $join->on('CITRN_DOCNO', '=', 'TDLVORDDETA_DLVCD')
                    ->on('CITRN_ITMCD', '=', 'TDLVORDDETA_ITMCD_ACT')
                    ->on('CITRN_BRANCH', '=', 'TDLVORDDETA_BRANCH');
            })->leftJoin('T_SLODETA', function ($join) {
                $join->on('TDLVORDDETA_SLOCD', '=', 'TSLODETA_SLOCD')
                    ->on('TDLVORDDETA_ITMCD', '=', 'TSLODETA_ITMCD')
                    ->on('TDLVORDDETA_BRANCH', '=', 'TSLODETA_BRANCH');
            })->leftJoin('T_SLOHEAD', function ($join) {
                $join->on('TSLODETA_SLOCD', '=', 'TSLO_SLOCD')
                    ->on('TSLODETA_BRANCH', '=', 'TSLO_BRANCH');
            })->leftJoin('T_QUOHEAD', function ($join) {
                $join->on('TSLO_QUOCD', '=', 'TQUO_QUOCD')
                    ->on('TSLO_BRANCH', '=', 'TQUO_BRANCH');
            })->where('TQUO_TYPE', '1')
            ->whereNull('returned_at')
            ->get();
        return ['data' => $data];
    }
}
