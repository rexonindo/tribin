<?php

namespace App\Http\Controllers;

use App\Models\ApprovalHistory;
use App\Models\BranchPaymentAccount;
use App\Models\COMPANY_BRANCH;
use App\Models\CompanyGroup;
use App\Models\M_Condition;
use App\Models\M_USAGE;
use App\Models\T_QUOCOND;
use App\Models\T_QUODETA;
use App\Models\T_QUOHEAD;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class QuotationController extends Controller
{
    protected $fpdf;
    protected $dedicatedConnection;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->fpdf = new Fpdf;
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }
    public function index()
    {
        $Usages = M_USAGE::on($this->dedicatedConnection)->get();
        return view('transaction.quotation', ['usages' => $Usages]);
    }

    public function formReport()
    {
        return view('report.quotation');
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

        $LastLine = DB::connection($this->dedicatedConnection)->table('T_QUOHEAD')
            ->whereMonth('created_at', '=', date('m'))
            ->whereYear('created_at', '=', date('Y'))
            ->where('TQUO_BRANCH', Auth::user()->branch)
            ->max('TQUO_LINE');


        $Company = COMPANY_BRANCH::on($this->dedicatedConnection)->select(
            'quotation_letter_id'
        )
            ->where('connection', $this->dedicatedConnection)
            ->where('BRANCH', Auth::user()->branch)
            ->first();

        $quotationHeader = [];
        $newQuotationCode = '';
        if (!$LastLine) {
            $LastLine = 1;
            $newQuotationCode = '001/' . $Company->quotation_letter_id . '/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
        } else {
            $LastLine++;
            $newQuotationCode = substr('00' . $LastLine, -3) . '/' . $Company->quotation_letter_id . '/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
        }
        $quotationHeader = [
            'TQUO_QUOCD' => $newQuotationCode,
            'TQUO_CUSCD' => $request->TQUO_CUSCD,
            'TQUO_LINE' => $LastLine,
            'TQUO_ATTN' => $request->TQUO_ATTN,
            'TQUO_SBJCT' => $request->TQUO_SBJCT,
            'TQUO_ISSUDT' => $request->TQUO_ISSUDT,
            'TQUO_PROJECT_LOCATION' => $request->TQUO_PROJECT_LOCATION,
            'created_by' => Auth::user()->nick_name,
            'TQUO_BRANCH' => Auth::user()->branch,
            'TQUO_TYPE' => $request->TQUO_TYPE,
            'TQUO_SERVTRANS_COST' => $request->TQUO_SERVTRANS_COST ? $request->TQUO_SERVTRANS_COST : 0,
        ];

        # data quotation detail item
        $validator = Validator::make($request->all(), [
            'TQUODETA_ITMCD' => 'required|array',
            'TQUODETA_USAGE_DESCRIPTION' => 'required|array',
            'TQUODETA_PRC' => 'required|array',
            'TQUODETA_PRC.*' => 'required|numeric',
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
                'TQUODETA_USAGE' => 1,
                'TQUODETA_USAGE_DESCRIPTION' => $request->TQUODETA_USAGE_DESCRIPTION[$i],
                'TQUODETA_PRC' => $request->TQUODETA_PRC[$i],
                'TQUODETA_OPRPRC' => 0,
                'TQUODETA_MOBDEMOB' => 0,
                'TQUODETA_ELECTRICITY' => $request->TQUODETA_ELECTRICITY[$i],
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
                'TQUODETA_BRANCH' => Auth::user()->branch
            ];
        }

        # data quotation condition
        $validator = Validator::make($request->all(), [
            'TQUOCOND_CONDI' => 'required|array',
            'TQUOCOND_CONDI.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        T_QUOHEAD::on($this->dedicatedConnection)->create($quotationHeader);
        if (!empty($quotationDetail)) {
            T_QUODETA::on($this->dedicatedConnection)->insert($quotationDetail);
        }

        $countDetailCondition = count($request->TQUOCOND_CONDI);
        $quotationCondition = [];
        for ($i = 0; $i < $countDetailCondition; $i++) {
            $quotationCondition[] = [
                'TQUOCOND_QUOCD' => $newQuotationCode,
                'TQUOCOND_CONDI' => $request->TQUOCOND_CONDI[$i],
                'TQUOCOND_BRANCH' => Auth::user()->branch,
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        if (!empty($quotationCondition)) {
            T_QUOCOND::on($this->dedicatedConnection)->insert($quotationCondition);
        }
        return [
            'msg' => 'OK', 'doc' => $newQuotationCode, '$RSLast' => $LastLine, 'quotationHeader' => $quotationHeader, 'quotationDetail' => $quotationDetail
        ];
    }

    public function saveItem(Request $request)
    {
        # data quotation detail item
        $validator = Validator::make($request->all(), [
            'TQUODETA_QUOCD' => 'required',
            'TQUODETA_ITMCD' => 'required',
            'TQUODETA_PRC' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        if ($request->TQUO_TYPE === '1') {
            $validator = Validator::make($request->all(), [
                'TQUODETA_USAGE_DESCRIPTION' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 406);
            }
        }

        T_QUODETA::on($this->dedicatedConnection)->create([
            'TQUODETA_QUOCD' => base64_decode($request->id),
            'TQUODETA_ITMCD' => $request->TQUODETA_ITMCD,
            'TQUODETA_ITMQT' => $request->TQUODETA_ITMQT,
            'TQUODETA_USAGE' => 1,
            'TQUODETA_USAGE_DESCRIPTION' => $request->TQUODETA_USAGE_DESCRIPTION,
            'TQUODETA_PRC' => $request->TQUODETA_PRC,
            'TQUODETA_OPRPRC' => 0,
            'TQUODETA_MOBDEMOB' => 0,
            'TQUODETA_ELECTRICITY' => $request->TQUODETA_ELECTRICITY,
            'created_by' => Auth::user()->nick_name,
            'TQUODETA_BRANCH' => Auth::user()->branch
        ]);

        return [
            'msg' => 'OK.'
        ];
    }

    public function saveCondition(Request $request)
    {
        $quotationCondition[] = [
            'TQUOCOND_QUOCD' => $request->TQUOCOND_QUOCD,
            'TQUOCOND_CONDI' => $request->TQUOCOND_CONDI,
            'created_by' => Auth::user()->nick_name,
            'created_at' => date('Y-m-d H:i:s'),
            'TQUOCOND_BRANCH' => Auth::user()->branch
        ];
        if (!empty($quotationCondition)) {
            T_QUOCOND::on($this->dedicatedConnection)->insert($quotationCondition);
        }

        return [
            'msg' => 'OK'
        ];
    }

    public function update(Request $request)
    {
        # ubah data header
        $affectedRow = 0;
        $Quotation = T_QUOHEAD::on($this->dedicatedConnection)
            ->select(DB::raw("IFNULL(TQUO_APPROVAL_HIS,'') TQUO_APPROVAL_HIS"), 'TQUO_APPRVDT', 'TQUO_APPRVBY')
            ->where('TQUO_QUOCD', base64_decode($request->id))
            ->where('TQUO_BRANCH', Auth::user()->branch)
            ->first();
        if (!$Quotation->TQUO_APPRVDT) {
            $affectedRow = T_QUOHEAD::on($this->dedicatedConnection)
                ->where('TQUO_QUOCD', base64_decode($request->id))
                ->where('TQUO_BRANCH', Auth::user()->branch)
                ->whereNull('TQUO_APPRVDT')
                ->update([
                    'TQUO_CUSCD' => $request->TQUO_CUSCD, 'TQUO_ATTN' => $request->TQUO_ATTN, 'TQUO_SBJCT' => $request->TQUO_SBJCT, 'TQUO_ISSUDT' => $request->TQUO_ISSUDT
                ]);
        } else {
            $currentHistory = $Quotation->TQUO_APPROVAL_HIS;
            $newHistory = ['APPROVED_BY' => $Quotation->TQUO_APPRVBY, 'APPROVED_AT' => $Quotation->TQUO_APPRVDT];
            $finalHistory = $currentHistory . '#$' . json_encode($newHistory);
            $newHistory = ['RESUBMIT_BY' => Auth::user()->nick_name, 'RESUBMIT_AT' => date('Y-m-d H:i:s')];
            $finalHistory .= '#$' . json_encode($newHistory);
            $affectedRow = T_QUOHEAD::on($this->dedicatedConnection)
                ->where('TQUO_QUOCD', base64_decode($request->id))
                ->where('TQUO_BRANCH', Auth::user()->branch)
                ->update([
                    'TQUO_APPROVAL_HIS' => $finalHistory,
                    'TQUO_APPRVBY' => NULL,
                    'TQUO_APPRVDT' => NULL,
                    'TQUO_CUSCD' => $request->TQUO_CUSCD, 'TQUO_ATTN' => $request->TQUO_ATTN, 'TQUO_SBJCT' => $request->TQUO_SBJCT, 'TQUO_ISSUDT' => $request->TQUO_ISSUDT
                ]);
        }
        return ['msg' => $affectedRow ? 'OK' : 'No changes', 'data' =>  $Quotation];
    }

    public function updateItem(Request $request)
    {
        $affectedRow = 0;
        $Quotation = T_QUOHEAD::on($this->dedicatedConnection)
            ->select(DB::raw("IFNULL(TQUO_APPROVAL_HIS,'') TQUO_APPROVAL_HIS"), 'TQUO_APPRVDT', 'TQUO_APPRVBY')
            ->where('TQUO_QUOCD', $request->TQUO_QUOCD)
            ->where('TQUO_BRANCH', Auth::user()->branch)
            ->first();
        if ($Quotation->TQUO_APPRVDT) {
            $currentHistory = $Quotation->TQUO_APPROVAL_HIS;
            $newHistory = ['APPROVED_BY' => $Quotation->TQUO_APPRVBY, 'APPROVED_AT' => $Quotation->TQUO_APPRVDT];
            $finalHistory = $currentHistory . '#$' . json_encode($newHistory);
            $newHistory = ['RESUBMIT_BY' => Auth::user()->nick_name, 'RESUBMIT_AT' => date('Y-m-d H:i:s')];
            $finalHistory .= '#$' . json_encode($newHistory);
            $affectedRow = T_QUOHEAD::on($this->dedicatedConnection)
                ->where('TQUO_QUOCD', $request->TQUO_QUOCD)
                ->where('TQUO_BRANCH', Auth::user()->branch)
                ->update([
                    'TQUO_APPROVAL_HIS' => $finalHistory,
                    'TQUO_APPRVBY' => NULL,
                    'TQUO_APPRVDT' => NULL,
                ]);
        }
        # ubah data detail
        $affectedRow = T_QUODETA::on($this->dedicatedConnection)
            ->where('id', $request->id)
            ->where('TQUODETA_BRANCH', Auth::user()->branch)
            ->update([
                'TQUODETA_ITMCD' => $request->TQUODETA_ITMCD,
                'TQUODETA_ITMQT' => $request->TQUODETA_ITMQT,
                'TQUODETA_USAGE_DESCRIPTION' => $request->TQUODETA_USAGE_DESCRIPTION,
                'TQUODETA_PRC' => $request->TQUODETA_PRC,
                'TQUODETA_OPRPRC' => $request->TQUODETA_OPRPRC ?? 0,
                'TQUODETA_MOBDEMOB' => $request->TQUODETA_MOBDEMOB ?? 0,
                'TQUODETA_ELECTRICITY' => $request->TQUODETA_ELECTRICITY,
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'TQUO_QUOCD',
            'MCUS_CUSNM',
        ];

        $RS = $request->approval == '1' ? T_QUOHEAD::on($this->dedicatedConnection)->select(["TQUO_QUOCD", "TQUO_CUSCD", "MCUS_CUSNM", "TQUO_ISSUDT", "TQUO_SBJCT", "TQUO_ATTN", 'TQUO_TYPE', 'TQUO_SERVTRANS_COST', 'MCUS_ADDR1', 'TQUO_PROJECT_LOCATION'])
            ->leftJoin("M_CUS", "TQUO_CUSCD", "=", "MCUS_CUSCD")
            ->leftJoin('T_SLOHEAD', 'TQUO_QUOCD', '=', 'TSLO_QUOCD')
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->whereNotNull("TQUO_APPRVDT")
            ->whereNull("TSLO_QUOCD")
            ->where('TQUO_BRANCH', Auth::user()->branch)
            ->get()
            : T_QUOHEAD::on($this->dedicatedConnection)->select(["TQUO_QUOCD", "TQUO_CUSCD", "MCUS_CUSNM", "TQUO_ISSUDT", "TQUO_SBJCT", "TQUO_ATTN", 'TQUO_TYPE', 'TQUO_SERVTRANS_COST', 'TQUO_PROJECT_LOCATION'])
            ->leftJoin("M_CUS", "TQUO_CUSCD", "=", "MCUS_CUSCD")
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->where('TQUO_BRANCH', Auth::user()->branch)
            ->get();
        return ['data' => $RS];
    }

    function loadById(Request $request)
    {
        $documentNumber = base64_decode($request->id);

        $RS = T_QUODETA::on($this->dedicatedConnection)->select(["id", "TQUODETA_ITMCD", "MITM_ITMNM", "TQUODETA_USAGE_DESCRIPTION", "TQUODETA_PRC", "TQUODETA_OPRPRC", "TQUODETA_MOBDEMOB", 'TQUODETA_ITMQT', 'TQUODETA_ELECTRICITY'])
            ->leftJoin("M_ITM", function ($join) {
                $join->on("TQUODETA_ITMCD", "=", "MITM_ITMCD")
                    ->on('TQUODETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->where('TQUODETA_QUOCD', $documentNumber)
            ->where('TQUODETA_BRANCH', Auth::user()->branch)
            ->whereNull('deleted_at')->get();

        $Conditions = T_QUOCOND::on($this->dedicatedConnection)->select(["id", "TQUOCOND_CONDI"])
            ->where('TQUOCOND_QUOCD', $documentNumber)
            ->where('TQUOCOND_BRANCH', Auth::user()->branch)
            ->whereNull('deleted_at')->get();

        $RSHeader = T_QUOHEAD::on($this->dedicatedConnection)->select('TQUO_TYPE', 'TQUO_SERVTRANS_COST')
            ->where('TQUO_QUOCD', $documentNumber)
            ->where('TQUO_BRANCH', Auth::user()->branch)
            ->get();

        $Histories = ApprovalHistory::on($this->dedicatedConnection)
            ->where('code', $documentNumber)
            ->get();

        return [
            'dataItem' => $RS, 'dataCondition' => $Conditions,
            'dataHeader' => $RSHeader, 'approvalHistories' => $Histories
        ];
    }

    function deleteConditionById(Request $request)
    {
        $affectedRow = T_QUOCOND::on($this->dedicatedConnection)->where('id', $request->id)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::user()->nick_name
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'could not be deleted', 'affectedRow' => $affectedRow];
    }

    function deleteItemById(Request $request)
    {
        $affectedRow = T_QUODETA::on($this->dedicatedConnection)->where('id', $request->id)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::user()->nick_name
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'could not be deleted', 'affectedRow' => $affectedRow];
    }

    function notifications()
    {
        $dataTobeApproved = [];
        $dataApproved = [];
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        if (in_array($activeRole['code'], ['accounting', 'director', 'manager', 'general_manager'])) {
            # Query untuk data Quotation
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_QUODETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD,TQUODETA_BRANCH")
                ->groupBy("TQUODETA_QUOCD", "TQUODETA_BRANCH")
                ->whereNull('deleted_at');
            $dataTobeApproved = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT,max(TQUO_ATTN) TQUO_ATTN,TQUO_BRANCH, TQUO_TYPE"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD")
                        ->on("TQUO_BRANCH", "=", "TQUODETA_BRANCH");
                })
                ->join('M_CUS', 'TQUO_CUSCD', '=', 'MCUS_CUSCD')
                ->whereNull("TQUO_APPRVDT")
                ->whereNull("TQUO_REJCTDT")
                ->groupBy('TQUO_QUOCD', 'TQUO_BRANCH', 'TQUO_TYPE')->get();
        }
        if (in_array($activeRole['code'], ['marketing', 'marketing_adm'])) {
            $LatestApprovalStatus = ApprovalHistory::on($this->dedicatedConnection)
                ->select('code', DB::raw("MAX(id) id"), 'branch')
                ->where('form', 'QUOTATION')
                ->where('branch', Auth::user()->branch)
                ->groupBy('code', 'branch');

            $ApprovalQuotation = ApprovalHistory::on($this->dedicatedConnection)
                ->select('v1.*', 'type')
                ->joinSub($LatestApprovalStatus, 'v1', function ($join) {
                    $join->on('approval_histories.id', '=', 'v1.id');
                });

            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_QUODETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
                ->groupBy("TQUODETA_QUOCD")
                ->where('TQUODETA_BRANCH', Auth::user()->branch)
                ->whereNull('deleted_at');

            $dataApproved = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT, max(TQUO_REJCTDT) TQUO_REJCTDT, max(TQUO_APPRVDT) TQUO_APPRVDT, type"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
                })
                ->join('M_CUS', function ($join) {
                    $join->on('TQUO_CUSCD', '=', 'MCUS_CUSCD')->on('TQUO_BRANCH', '=', 'MCUS_BRANCH');
                })
                ->leftJoin('T_SLOHEAD', function ($join) {
                    $join->on('TQUO_QUOCD', '=', 'TSLO_QUOCD')->on('TQUO_BRANCH', '=', 'TSLO_BRANCH');
                })
                ->leftJoinSub($ApprovalQuotation, 'v11', function ($join) {
                    $join->on('TQUO_QUOCD', '=', 'v11.code')->on('TQUO_BRANCH', '=', 'v11.branch');
                })
                ->whereNull("TSLO_QUOCD")
                ->where('T_QUOHEAD.created_by', Auth::user()->nick_name)
                ->where('TQUO_BRANCH', Auth::user()->branch)
                ->groupBy('TQUO_QUOCD', 'type')->get();
        }

        return [
            'data' => $dataTobeApproved, 'dataApproved' => $dataApproved,
        ];
    }

    public function formApproval()
    {
        return view('transaction.approval');
    }

    public function toPDF(Request $request)
    {
        $RSCG = COMPANY_BRANCH::on($this->dedicatedConnection)->select('name', 'address', 'phone', 'fax', 'letter_head')
            ->where('connection', $this->dedicatedConnection)
            ->where('BRANCH', Auth::user()->branch)
            ->first();

        $doc = base64_decode($request->id);
        $RSHeader = T_QUOHEAD::on($this->dedicatedConnection)->select(
            'MCUS_CUSNM',
            'TQUO_ATTN',
            'MCUS_TELNO',
            'TQUO_SBJCT',
            'TQUO_ISSUDT',
            'TQUO_APPRVDT',
            'TQUO_TYPE',
            'TQUO_SERVTRANS_COST',
            'T_QUOHEAD.created_by',
            'TQUO_PROJECT_LOCATION'
        )
            ->leftJoin("M_CUS", "TQUO_CUSCD", "=", "MCUS_CUSCD")
            ->where("TQUO_QUOCD", $doc)
            ->where('TQUO_BRANCH', Auth::user()->branch)
            ->first();
        $MCUS_CUSNM = $RSHeader->MCUS_CUSNM;
        $TQUO_ATTN = $RSHeader->TQUO_ATTN;
        $MCUS_TELNO = $RSHeader->MCUS_TELNO;
        $TQUO_SBJCT = $RSHeader->TQUO_SBJCT;
        $_ISSUDT = explode('-', $RSHeader->TQUO_ISSUDT);
        $TQUO_ISSUDT = $_ISSUDT[2] . '/' . $_ISSUDT[1] . '/' . $_ISSUDT[0];
        $TQUO_APPRVDT = $RSHeader->TQUO_APPRVDT;

        $RSDetail = T_QUODETA::on($this->dedicatedConnection)->select(
            'TQUODETA_ITMCD',
            'MITM_BRAND',
            'MITM_ITMNM',
            'MITM_MODEL',
            'TQUODETA_USAGE_DESCRIPTION',
            'TQUODETA_PRC',
            'TQUODETA_OPRPRC',
            'TQUODETA_MOBDEMOB',
            'TQUODETA_ITMQT',
            'MITM_STKUOM',
            'TQUODETA_ELECTRICITY'
        )
            ->leftJoin("M_ITM", function ($join) {
                $join->on("TQUODETA_ITMCD", "=", "MITM_ITMCD")
                    ->on('TQUODETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->whereNull("deleted_at")
            ->where("TQUODETA_QUOCD", $doc)
            ->where('TQUODETA_BRANCH', Auth::user()->branch)
            ->get()->toArray();

        $RSCondition = T_QUOCOND::on($this->dedicatedConnection)->select('TQUOCOND_CONDI')
            ->where('TQUOCOND_QUOCD', $doc)
            ->whereNull("deleted_at")
            ->where('TQUOCOND_BRANCH', Auth::user()->branch)
            ->get()->toArray();
        $User = User::where('nick_name', $RSHeader->created_by)->select('name', 'phone')->first();

        $this->fpdf->SetFont('Arial', 'BU', 24);
        $this->fpdf->SetAutoPageBreak(true, 1);
        // $this->fpdf->SetMargins(0, 0);
        $this->fpdf->AddPage("P", 'A4');
        $this->fpdf->SetXY(7, 3);
        $this->fpdf->Cell(0, 8, $RSCG->letter_head, 0, 0, 'C');
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->SetXY(7, 13);
        $this->fpdf->Cell(0, 5, 'SALES & RENTAL DIESEL GENSET - FORKLIF - TRAVOLAS - TRUK', 0, 0, 'C');

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(7, 18);
        $this->fpdf->MultiCell(0, 5, $RSCG->address, 0, 'C');
        $this->fpdf->line(7, 29, 202, 29);
        $this->fpdf->line(7, 28, 202, 28);

        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->SetXY(7, 31);
        $this->fpdf->Cell(15, 5, 'To', 0, 0, 'L');
        $this->fpdf->Cell(10, 5, '', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $MCUS_CUSNM, 0, 0, 'L');
        $this->fpdf->SetXY(7, 36);
        $this->fpdf->Cell(15, 5, 'Attn', 0, 0, 'L');
        $this->fpdf->Cell(10, 5, '', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $TQUO_ATTN, 0, 0, 'L');
        $this->fpdf->SetXY(7, 41);
        $this->fpdf->Cell(15, 5, 'Telp', 0, 0, 'L');
        $this->fpdf->Cell(10, 5, '', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $MCUS_TELNO, 0, 0, 'L');
        $this->fpdf->SetXY(7, 46);
        $this->fpdf->Cell(15, 5, 'Email', 0, 0, 'L');
        $this->fpdf->Cell(10, 5, '', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ':', 0, 0, 'L');
        $this->fpdf->SetXY(7, 51);
        $this->fpdf->Cell(15, 5, 'Subject', 0, 0, 'L');
        $this->fpdf->Cell(10, 5, '', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $TQUO_SBJCT, 0, 0, 'L');
        $this->fpdf->SetXY(7, 56);
        $this->fpdf->Cell(15, 5, 'Project Location', 0, 0, 'L');
        $this->fpdf->Cell(10, 5, '', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $RSHeader->TQUO_PROJECT_LOCATION, 0, 0, 'L');

        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->SetXY(140, 31);
        $this->fpdf->Cell(15, 5, 'Date', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $TQUO_ISSUDT, 0, 0, 'L');
        $this->fpdf->SetXY(140, 36);
        $this->fpdf->Cell(15, 5, 'Our Ref', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $doc, 0, 0, 'L');
        $this->fpdf->SetXY(140, 41);
        $this->fpdf->Cell(15, 5, 'From', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $User->name, 0, 0, 'L');
        $this->fpdf->SetXY(140, 46);
        $this->fpdf->Cell(15, 5, 'Telp', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $User->phone, 0, 0, 'L');
        $this->fpdf->SetXY(140, 51);
        $this->fpdf->Cell(15, 5, 'Fax', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $RSCG->fax, 0, 0, 'L');

        $this->fpdf->SetXY(7, 61);
        $this->fpdf->MultiCell(0, 5, 'Dengan hormat,', 0, 'J');

        if ($RSHeader->TQUO_TYPE === '1') {
            $this->fpdf->SetXY(7, 66);
            $this->fpdf->MultiCell(0, 5, 'Bersama ini kami sampaikan ' . $TQUO_SBJCT . ' dengan data sebagai berikut :', 0, 'J');

            $this->fpdf->SetXY(6, 72);
            $this->fpdf->Cell(7, 5, 'No', 1, 0, 'L');
            $this->fpdf->Cell(30, 5, 'Item', 1, 0, 'L');
            $this->fpdf->Cell(45, 5, 'Pemakaian', 1, 0, 'L');
            $this->fpdf->Cell(30, 5, 'Freq/Volt', 1, 0, 'C');
            $this->fpdf->Cell(10, 5, 'Qty', 1, 0, 'C');
            $this->fpdf->Cell(25, 5, 'Harga Sewa', 1, 0, 'C');
            $this->fpdf->Cell(25, 5, 'Total', 1, 0, 'C');

            $y = 77;
            $NomorUrut = 1;
            foreach ($RSDetail as $r) {
                $this->fpdf->SetXY(6, $y);
                $this->fpdf->Cell(7, 10, $NomorUrut++, 1, 0, 'L');

                $this->fpdf->Cell(30, 10, '', 1, 0, 'L');
                $ttlwidth = $this->fpdf->GetStringWidth($r['MITM_ITMNM']);
                if ($ttlwidth > 30) {
                    $ukuranfont = 8.5;
                    while ($ttlwidth > 30) {
                        $this->fpdf->SetFont('Arial', '', $ukuranfont);
                        $ttlwidth = $this->fpdf->GetStringWidth($r['MITM_ITMNM']);
                        $ukuranfont = $ukuranfont - 0.5;
                    }
                }
                $this->fpdf->Text(14, $y + 4, $r['MITM_ITMNM']);

                $this->fpdf->SetFont('Arial', '', 9);
                $this->fpdf->Cell(45, 10, '', 1, 0, 'L');
                $this->fpdf->SetXY(43, $y);
                $this->fpdf->MultiCell(45, 5, $r['TQUODETA_USAGE_DESCRIPTION'], 0, 'L');

                $this->fpdf->SetXY(88, $y);
                $this->fpdf->SetFont('Arial', '', 9);
                $ttlwidth = $this->fpdf->GetStringWidth($r['TQUODETA_ELECTRICITY']);
                if ($ttlwidth > 35) {
                    $ukuranfont = 8.5;
                    while ($ttlwidth > 35) {
                        $this->fpdf->SetFont('Arial', '', $ukuranfont);
                        $ttlwidth = $this->fpdf->GetStringWidth($r['TQUODETA_ELECTRICITY']);
                        $ukuranfont = $ukuranfont - 0.5;
                    }
                }
                $this->fpdf->Cell(30, 10, $r['TQUODETA_ELECTRICITY'], 1, 0, 'C');

                $this->fpdf->SetFont('Arial', '', 9);
                $this->fpdf->Cell(10, 10, $r['TQUODETA_ITMQT'], 1, 0, 'C');
                $this->fpdf->Cell(25, 10, number_format($r['TQUODETA_PRC']), 1, 0, 'C');
                $this->fpdf->Cell(25, 10, number_format($r['TQUODETA_PRC'] * $r['TQUODETA_ITMQT']), 1, 0, 'C');

                $y += 10;
            }
            $y += 5;
            $this->fpdf->SetXY(7, $y);
            $this->fpdf->Cell(20, 5, 'RENTAL CONDITION :', 0, 0, 'L');
            $y += 5;
            $orderNo = 1;
            foreach ($RSCondition as $r) {
                $this->fpdf->SetXY(9, $y);
                $this->fpdf->Cell(5, 5, $orderNo . '.', 0, 0, 'L');
                $this->fpdf->MultiCell(0, 5, $r['TQUOCOND_CONDI'], 0, 'J');
                $YExtra_candidate = $this->fpdf->GetY();
                $YExtra = $YExtra_candidate != $y ? $YExtra = $YExtra_candidate - $y - 5 : 0;
                $y += 5 + $YExtra;
                $orderNo++;
            }

            $y += 5;
            $this->fpdf->SetXY(7, $y);
            $this->fpdf->MultiCell(0, 5, 'Besar harapan kami penawaran ini dapat menjadi pertimbangan prioritas untuk pengadaan kebutuhan di Perusahaan Bapak / Ibu. Demikian kami sampaikan penawaran ini, dan sambil menunggu kabar lebih lanjut, atas perhatian dan kerjasama yang baik kami ucapkan banyak terima kasih.', 0, 'J');
        } else {
            $this->fpdf->SetXY(7, 66);
            $this->fpdf->MultiCell(0, 5, 'Sebelumnya kami ucapkan terima kasih atas kepercayaan yang diberikan kepada kami,', 0, 'J');
            $this->fpdf->SetXY(7, 71);
            $this->fpdf->MultiCell(0, 5, 'dengan ini kami sampaikan surat penawaran dengan rincian sebagai berikut :', 0, 'J');
            $this->fpdf->SetXY(7, 76);
            $this->fpdf->Cell(7, 5, 'No', 1, 0, 'L');
            $this->fpdf->Cell(85, 5, 'Keterangan', 1, 0, 'L');
            $this->fpdf->Cell(20, 5, 'Jumlah', 1, 0, 'C');
            $this->fpdf->Cell(21, 5, 'Satuan', 1, 0, 'C');
            $this->fpdf->Cell(30, 5, 'Harga', 1, 0, 'C');
            $this->fpdf->Cell(30, 5, 'Total', 1, 0, 'C');
            $y = 81;
            $nomor = 1;
            $GrandTotal = 0;
            $SubTotal = 0;
            foreach ($RSDetail as $r) {
                $LineTotal = $r['TQUODETA_PRC'] * $r['TQUODETA_ITMQT'];
                $this->fpdf->SetXY(7, $y);
                $this->fpdf->Cell(7, 5, $nomor++, 1, 0, 'L');
                $ttlwidth = $this->fpdf->GetStringWidth($r['MITM_ITMNM']);
                if ($ttlwidth > 85) {
                    $ukuranfont = 8.5;
                    while ($ttlwidth > 85) {
                        $this->fpdf->SetFont('Arial', '', $ukuranfont);
                        $ttlwidth = $this->fpdf->GetStringWidth($r['MITM_ITMNM']);
                        $ukuranfont = $ukuranfont - 0.5;
                    }
                }
                $this->fpdf->Cell(85, 5, $r['MITM_ITMNM'], 1, 0, 'L');
                $this->fpdf->SetFont('Arial', '', 9);
                $this->fpdf->Cell(20, 5, $r['TQUODETA_ITMQT'], 1, 0, 'C');
                $this->fpdf->Cell(21, 5, $r['MITM_STKUOM'], 1, 0, 'C');
                $this->fpdf->Cell(30, 5, number_format($r['TQUODETA_PRC']), 1, 0, 'C');
                $this->fpdf->Cell(30, 5, number_format($LineTotal), 1, 0, 'C');
                $y += 5;
                $SubTotal += $LineTotal;
            }
            $GrandTotal = $SubTotal + $RSHeader->TQUO_SERVTRANS_COST;
            $this->fpdf->SetXY(7, $y);
            $this->fpdf->Cell(7, 5, '', 1, 0, 'L');
            $this->fpdf->Cell(85, 5, 'Total', 1, 0, 'L');
            $this->fpdf->Cell(20, 5, '', 1, 0, 'C');
            $this->fpdf->Cell(21, 5, '', 1, 0, 'C');
            $this->fpdf->Cell(30, 5, '', 1, 0, 'C');
            $this->fpdf->Cell(30, 5, number_format($SubTotal), 1, 0, 'C');
            $y += 5;
            $this->fpdf->SetXY(7, $y);
            $this->fpdf->Cell(7, 5, '', 1, 0, 'L');
            $this->fpdf->Cell(85, 5, 'Jasa Service & Transportasi', 1, 0, 'L');
            $this->fpdf->Cell(20, 5, '', 1, 0, 'C');
            $this->fpdf->Cell(21, 5, '', 1, 0, 'C');
            $this->fpdf->Cell(30, 5, '', 1, 0, 'C');
            $this->fpdf->Cell(30, 5, number_format($RSHeader->TQUO_SERVTRANS_COST), 1, 0, 'C');
            $y += 5;
            $this->fpdf->SetXY(7, $y);
            $this->fpdf->Cell(7, 5, '', 1, 0, 'L');
            $this->fpdf->Cell(85 + 20 + 21 + 30, 5, 'Grand Total', 1, 0, 'C');
            $this->fpdf->Cell(30, 5, number_format($GrandTotal), 1, 0, 'C');

            $y += 10;
            $this->fpdf->SetXY(7, $y);
            $this->fpdf->Cell(20, 5, 'Note :', 0, 0, 'L');
            $y += 5;
            $orderNo = 1;
            foreach ($RSCondition as $r) {
                $this->fpdf->SetXY(9, $y);
                $this->fpdf->Cell(5, 5, $orderNo . '.', 0, 0, 'L');
                $this->fpdf->MultiCell(0, 5, $r['TQUOCOND_CONDI'], 0, 'J');
                $YExtra_candidate = $this->fpdf->GetY();
                $YExtra = $YExtra_candidate != $y ? $YExtra = $YExtra_candidate - $y - 5 : 0;
                $y += 5 + $YExtra;
                $orderNo++;
            }
        }

        $branchPaymentAccount = BranchPaymentAccount::on($this->dedicatedConnection)
            ->where('BRANCH', Auth::user()->branch)
            ->whereNull('deleted_at')
            ->get();

        $y += 15;
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(6, $y);
        $this->fpdf->Cell(80, 5, 'BANK', 1, 0, 'C');
        $this->fpdf->Cell(70, 5, 'Atas Nama', 1, 0, 'C');
        $this->fpdf->Cell(50, 5, 'Nomor Rekening', 1, 0, 'C');

        $y += 5;
        $this->fpdf->SetFont('Arial', '', 10);
        foreach ($branchPaymentAccount as $r) {
            $this->fpdf->SetXY(6, $y);
            $this->fpdf->Cell(80, 5, $r->bank_name, 1, 0, 'C');
            $this->fpdf->Cell(70, 5, $r->bank_account_name, 1, 0, 'C');
            $this->fpdf->Cell(50, 5, $r->bank_account_number, 1, 0, 'C');
            $y += 5;
        }

        $y += 10;
        $this->fpdf->SetXY(7, $y);
        $this->fpdf->Cell(20, 5, 'Hormat kami,', 0, 0, 'L');
        $y += 5;
        $this->fpdf->SetXY(7, $y);
        $this->fpdf->Cell(20, 5, 'Dibuat oleh', 0, 0, 'L');
        $this->fpdf->Cell(130, 5, ' Diketahui oleh,', 0, 0, 'C');
        $this->fpdf->Cell(40, 5, ' Disetujui oleh,', 0, 0, 'C');

        $y += 25;
        $this->fpdf->SetXY(7, $y);
        $this->fpdf->Image(storage_path('app/public/mkt_sign.jpg'), 7, $y - 19, 15, 15);
        if (!empty($TQUO_APPRVDT)) {
            $this->fpdf->Image(storage_path('app/public/dir_sign.jpg'), 85, $y - 19, 15, 15);
        }
        $y -= 5;
        $this->fpdf->SetXY(7, $y);
        $this->fpdf->Cell(20, 5, 'Marketing Dept.', 0, 0, 'L');
        $this->fpdf->Cell(130, 5, ' Pimpinan,', 0, 0, 'C');
        $this->fpdf->Cell(40, 5, ' Penyewa/pembeli', 0, 0, 'C');

        $this->fpdf->SetXY(6, $this->fpdf->GetPageHeight() - 9);
        $this->fpdf->Cell(0, 5, 'Cetakan dari system komputer tidak memerlukan tanda tangan basah', 1, 0, 'C');
        $this->fpdf->Output('quotation ' . $doc . '.pdf', 'I');
        exit;
    }

    function approve(Request $request)
    {
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        $documentNumber = base64_decode($request->id);

        if (in_array($activeRole['code'], ['accounting', 'director', 'manager', 'general_manager'])) {

            $affectedRow = T_QUOHEAD::on($this->dedicatedConnection)
                ->where('TQUO_QUOCD', $documentNumber)
                ->where('TQUO_BRANCH', $request->TQUO_BRANCH)
                ->whereNull('TQUO_APPRVBY')
                ->update([
                    'TQUO_APPRVBY' => Auth::user()->nick_name, 'TQUO_APPRVDT' => date('Y-m-d H:i:s')
                ]);

            ApprovalHistory::on($this->dedicatedConnection)->create([
                'created_by' => Auth::user()->nick_name,
                'form' => 'QUOTATION',
                'code' => $documentNumber,
                'type' => '3',
                'remark' => '-',
                'branch' => $request->TQUO_BRANCH,
            ]);

            $message = $affectedRow ? 'Approved' : 'Something wrong please contact admin';

            return ['message' => $message];
        } else {
            return response()->json(['message' => 'forbidden'], 403);
        }
    }

    function reject(Request $request)
    {
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        if (in_array($activeRole['code'], ['accounting', 'director', 'manager', 'general_manager'])) {
            $affectedRow = T_QUOHEAD::on($this->dedicatedConnection)
                ->where('TQUO_QUOCD', base64_decode($request->id))
                ->where('TQUO_BRANCH', $request->TQUO_BRANCH)
                ->update([
                    'TQUO_REJCTBY' => Auth::user()->nick_name, 'TQUO_REJCTDT' => date('Y-m-d H:i:s')
                ]);
            $message = $affectedRow ? 'Approved' : 'Something wrong please contact admin';
            return ['message' => $message];
        } else {
            return response()->json(['message' => 'forbidden'], 403);
        }
    }

    function formApproved()
    {
        return view('transaction.approved_quotation');
    }

    function report(Request $request)
    {
        $RS = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::raw("T_QUOHEAD.*,MCUS_CUSNM,TQUODETA_ITMCD,MITM_ITMNM,TQUODETA_ITMQT,TQUODETA_USAGE_DESCRIPTION,TQUODETA_PRC,TQUODETA_OPRPRC,TQUODETA_MOBDEMOB"))
            ->leftJoin('T_QUODETA', function ($join) {
                $join->on('TQUO_QUOCD', '=', 'TQUODETA_QUOCD')
                    ->on('TQUO_BRANCH', '=', 'TQUODETA_BRANCH');
            })
            ->leftJoin('M_ITM', function ($join) {
                $join->on('TQUODETA_ITMCD', '=', 'MITM_ITMCD')
                    ->on('TQUODETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->join('M_CUS', function ($join) {
                $join->on('TQUO_CUSCD', '=', 'MCUS_CUSCD')->on('TQUO_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->where("TQUO_ISSUDT", ">=", $request->dateFrom)
            ->where("TQUO_ISSUDT", "<=", $request->dateTo)
            ->whereNull("T_QUODETA.deleted_at")
            ->get()->toArray();
        if ($request->fileType === 'json') {
            return ['data' => $RS];
        } else {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('QUOTATION');
            $sheet->freezePane('A2');

            $sheet->fromArray(array_keys($RS[0]), null, 'A1');
            $sheet->fromArray($RS, null, 'A2');

            foreach (range('A', 'Z') as $r) {
                $sheet->getColumnDimension($r)->setAutoSize(true);
            }

            $sheet = $spreadsheet->createSheet();
            $sheet->setTitle('CONDITION');
            $RS = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::raw("T_QUOCOND.*"))
                ->leftJoin('T_QUOCOND', 'TQUO_QUOCD', '=', 'TQUOCOND_QUOCD')
                ->where("TQUO_ISSUDT", ">=", $request->dateFrom)
                ->where("TQUO_ISSUDT", "<=", $request->dateTo)
                ->get()->toArray();
            $sheet->fromArray(array_keys($RS[0]), null, 'A1');
            $sheet->fromArray($RS, null, 'A2');
            foreach (range('A', 'Z') as $r) {
                $sheet->getColumnDimension($r)->setAutoSize(true);
            }

            $stringjudul = "Quotation Report " . date('Y-m-d H:i:s');
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $filename = $stringjudul;
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }
    }

    function getAllCondition()
    {
        return ['data' => M_Condition::on($this->dedicatedConnection)->select('MCONDITION_ORDER_NUMBER', 'MCONDITION_DESCRIPTION')
            ->orderBy('MCONDITION_ORDER_NUMBER', 'ASC')
            ->get()];
    }

    function revise(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'remark' => 'required|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        ApprovalHistory::on($this->dedicatedConnection)->create([
            'created_by' => Auth::user()->nick_name,
            'form' => 'QUOTATION',
            'code' => base64_decode($request->id),
            'type' => '2',
            'remark' => $request->remark,
            'branch' => $request->TQUO_BRANCH,
        ]);

        return ['message' => 'OK'];
    }
}
