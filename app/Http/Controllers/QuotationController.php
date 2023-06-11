<?php

namespace App\Http\Controllers;

use App\Models\T_QUOCOND;
use App\Models\T_QUODETA;
use App\Models\T_QUOHEAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;

class QuotationController extends Controller
{
    protected $fpdf;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->fpdf = new Fpdf;
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
            $LastLine = 1;
            $newQuotationCode = '001/PT/PNW/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
        } else {
            $LastLine++;
            $newQuotationCode = substr('00' . $LastLine, -3) . '/PT/PNW/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
        }
        $quotationHeader = [
            'TQUO_QUOCD' => $newQuotationCode,
            'TQUO_CUSCD' => $request->TQUO_CUSCD,
            'TQUO_LINE' => $LastLine,
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

    public function saveCondition(Request $request)
    {
        $quotationCondition[] = [
            'TQUOCOND_QUOCD' => $request->TQUOCOND_QUOCD,
            'TQUOCOND_CONDI' => $request->TQUOCOND_CONDI,
            'created_by' => Auth::user()->nick_name,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        if (!empty($quotationCondition)) {
            T_QUOCOND::insert($quotationCondition);
        }
        
        return [
            'msg' => 'OK'
        ];
    }


    public function update(Request $request)
    {
        # ubah data header
        $affectedRow = T_QUOHEAD::where('TQUO_QUOCD', base64_decode($request->id))
            ->update([
                'TQUO_CUSCD' => $request->TQUO_CUSCD, 'TQUO_ATTN' => $request->TQUO_ATTN, 'TQUO_SBJCT' => $request->TQUO_SBJCT, 'TQUO_ISSUDT' => $request->TQUO_ISSUDT
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'TQUO_QUOCD',
            'MCUS_CUSNM',
        ];

        $RS = $request->approval == '1' ? T_QUOHEAD::select(["TQUO_QUOCD", "TQUO_CUSCD", "MCUS_CUSNM", "TQUO_ISSUDT", "TQUO_SBJCT", "TQUO_ATTN"])
            ->leftJoin("M_CUS", "TQUO_CUSCD", "=", "MCUS_CUSCD")
            ->leftJoin('T_SLOHEAD', 'TQUO_QUOCD', '=', 'TSLO_QUOCD')
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->whereNotNull("TQUO_APPRVDT")
            ->whereNull("TSLO_QUOCD")
            ->get()
            : T_QUOHEAD::select(["TQUO_QUOCD", "TQUO_CUSCD", "MCUS_CUSNM", "TQUO_ISSUDT", "TQUO_SBJCT", "TQUO_ATTN"])
            ->leftJoin("M_CUS", "TQUO_CUSCD", "=", "MCUS_CUSCD")
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->get();
        return ['data' => $RS];
    }

    function loadById(Request $request)
    {
        $RS = T_QUODETA::select(["id", "TQUODETA_ITMCD", "MITM_ITMNM", "TQUODETA_USAGE", "TQUODETA_PRC", "TQUODETA_OPRPRC", "TQUODETA_MOBDEMOB"])
            ->leftJoin("M_ITM", "TQUODETA_ITMCD", "=", "MITM_ITMCD")
            ->where('TQUODETA_QUOCD', base64_decode($request->id))
            ->whereNull('deleted_at')->get();
        $RS1 = T_QUOCOND::select(["id", "TQUOCOND_CONDI"])
            ->where('TQUOCOND_QUOCD', base64_decode($request->id))
            ->whereNull('deleted_at')->get();
        return ['dataItem' => $RS, 'dataCondition' => $RS1];
    }

    function deleteConditionById(Request $request)
    {
        $affectedRow = T_QUOCOND::where('id', $request->id)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::user()->nick_name
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'could not be deleted', 'affectedRow' => $affectedRow];
    }

    function deleteItemById(Request $request)
    {
        $affectedRow = T_QUODETA::where('id', $request->id)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::user()->nick_name
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'could not be deleted', 'affectedRow' => $affectedRow];
    }

    function notifications()
    {
        $dataTobeApproved = [];
        $dataApproved = [];
        if (in_array(Auth::user()->role, ['accounting', 'director'])) {
            $RSDetail = DB::table('T_QUODETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
                ->groupBy("TQUODETA_QUOCD")
                ->whereNull('deleted_at');
            $dataTobeApproved = T_QUOHEAD::select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
                })
                ->join('M_CUS', 'TQUO_CUSCD', '=', 'MCUS_CUSCD')
                ->whereNull("TQUO_APPRVDT")->groupBy('TQUO_QUOCD')->get();
        }
        if (in_array(Auth::user()->role, ['marketing', 'marketing_adm'])) {
            $RSDetail = DB::table('T_QUODETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
                ->groupBy("TQUODETA_QUOCD")
                ->whereNull('deleted_at');
            $dataApproved = T_QUOHEAD::select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
                })
                ->join('M_CUS', 'TQUO_CUSCD', '=', 'MCUS_CUSCD')
                ->leftJoin('T_SLOHEAD', 'TQUO_QUOCD', '=', 'TSLO_QUOCD')
                ->whereNotNull("TQUO_APPRVDT")
                ->whereNull("TSLO_QUOCD")
                ->groupBy('TQUO_QUOCD')
                ->get();
        }

        return ['data' => $dataTobeApproved, 'dataApproved' => $dataApproved];
    }

    public function formApproval()
    {
        return view('transaction.approval');
    }

    public function toPDF()
    {
        $this->fpdf->SetFont('Arial', 'BU', 24);
        $this->fpdf->AddPage("P", 'A4');
        $this->fpdf->SetXY(7, 5);
        $this->fpdf->Cell(0, 8, 'JAYA ABADI TEKNIK', 0, 0, 'C');
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->SetXY(7, 13);
        $this->fpdf->Cell(0, 5, 'SALES & RENTAL DIESEL GENSET - FORKLIF - TRAVOLAS - TRUK', 0, 0, 'C');

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(7, 18);
        $this->fpdf->MultiCell(0, 5, 'Alamat Kantor : Jl. Tembusan Terminal No.19-20 Km. 12 Alang-alang Lebar,  Palembang - Indonesia Telp. (0711) 5645971 - 5645108  fax. (0711) 5645972', 0, 'C');

        $this->fpdf->Output();

        exit;
    }

    function approve(Request $request)
    {
        if (in_array(Auth::user()->role, ['accounting', 'director'])) {
            $affectedRow = T_QUOHEAD::where('TQUO_QUOCD', base64_decode($request->id))
                ->update([
                    'TQUO_APPRVBY' => Auth::user()->nick_name, 'TQUO_APPRVDT' => date('Y-m-d H:i:s')
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
}
