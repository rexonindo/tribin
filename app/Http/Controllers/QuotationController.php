<?php

namespace App\Http\Controllers;

use App\Models\M_Condition;
use App\Models\T_QUOCOND;
use App\Models\T_QUODETA;
use App\Models\T_QUOHEAD;
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
        return view('transaction.quotation');
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
            'TQUO_BRANCH' => Auth::user()->branch,
            'TQUO_TYPE' => $request->TQUO_TYPE,
            'TQUO_SERVTRANS_COST' => $request->TQUO_SERVTRANS_COST,
        ];

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
        $affectedRow = T_QUOHEAD::on($this->dedicatedConnection)
            ->where('TQUO_QUOCD', base64_decode($request->id))
            ->where('TQUO_BRANCH', Auth::user()->branch)
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

        $RS = $request->approval == '1' ? T_QUOHEAD::on($this->dedicatedConnection)->select(["TQUO_QUOCD", "TQUO_CUSCD", "MCUS_CUSNM", "TQUO_ISSUDT", "TQUO_SBJCT", "TQUO_ATTN", 'TQUO_TYPE', 'TQUO_SERVTRANS_COST'])
            ->leftJoin("M_CUS", "TQUO_CUSCD", "=", "MCUS_CUSCD")
            ->leftJoin('T_SLOHEAD', 'TQUO_QUOCD', '=', 'TSLO_QUOCD')
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->whereNotNull("TQUO_APPRVDT")
            ->whereNull("TSLO_QUOCD")
            ->where('TQUO_BRANCH', Auth::user()->branch)
            ->get()
            : T_QUOHEAD::on($this->dedicatedConnection)->select(["TQUO_QUOCD", "TQUO_CUSCD", "MCUS_CUSNM", "TQUO_ISSUDT", "TQUO_SBJCT", "TQUO_ATTN", 'TQUO_TYPE', 'TQUO_SERVTRANS_COST'])
            ->leftJoin("M_CUS", "TQUO_CUSCD", "=", "MCUS_CUSCD")
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->where('TQUO_BRANCH', Auth::user()->branch)
            ->get();
        return ['data' => $RS];
    }

    function loadById(Request $request)
    {
        $RS = T_QUODETA::on($this->dedicatedConnection)->select(["id", "TQUODETA_ITMCD", "MITM_ITMNM", "TQUODETA_USAGE", "TQUODETA_PRC", "TQUODETA_OPRPRC", "TQUODETA_MOBDEMOB", 'TQUODETA_ITMQT'])
            ->leftJoin("M_ITM", function ($join) {
                $join->on("TQUODETA_ITMCD", "=", "MITM_ITMCD")
                    ->on('TQUODETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->where('TQUODETA_QUOCD', base64_decode($request->id))
            ->where('TQUODETA_BRANCH', Auth::user()->branch)
            ->whereNull('deleted_at')->get();
        $RS1 = T_QUOCOND::on($this->dedicatedConnection)->select(["id", "TQUOCOND_CONDI"])
            ->where('TQUOCOND_QUOCD', base64_decode($request->id))
            ->where('TQUOCOND_BRANCH', Auth::user()->branch)
            ->whereNull('deleted_at')->get();
        $RSHeader = T_QUOHEAD::on($this->dedicatedConnection)->select('TQUO_TYPE', 'TQUO_SERVTRANS_COST')
            ->where('TQUO_QUOCD', base64_decode($request->id))
            ->where('TQUO_BRANCH', Auth::user()->branch)
            ->get();
        return ['dataItem' => $RS, 'dataCondition' => $RS1, 'dataHeader' => $RSHeader];
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
        if (in_array($activeRole['code'], ['accounting', 'director'])) {
            # Query untuk data Quotation
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_QUODETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD,TQUODETA_BRANCH")
                ->groupBy("TQUODETA_QUOCD", "TQUODETA_BRANCH")
                ->whereNull('deleted_at');
            $dataTobeApproved = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT,max(TQUO_ATTN) TQUO_ATTN,TQUO_BRANCH"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD")
                        ->on("TQUO_BRANCH", "=", "TQUODETA_BRANCH");
                })
                ->join('M_CUS', 'TQUO_CUSCD', '=', 'MCUS_CUSCD')
                ->whereNull("TQUO_APPRVDT")
                ->whereNull("TQUO_REJCTDT")
                ->groupBy('TQUO_QUOCD', 'TQUO_BRANCH')->get();
        }
        if (in_array($activeRole['code'], ['marketing', 'marketing_adm'])) {
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_QUODETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
                ->groupBy("TQUODETA_QUOCD")
                ->where('TQUODETA_BRANCH', Auth::user()->branch)
                ->whereNull('deleted_at');
            $dataApproved = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT, max(TQUO_REJCTDT) TQUO_REJCTDT, max(TQUO_APPRVDT) TQUO_APPRVDT"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
                })
                ->join('M_CUS', function ($join) {
                    $join->on('TQUO_CUSCD', '=', 'MCUS_CUSCD')->on('TQUO_BRANCH', '=', 'MCUS_BRANCH');
                })
                ->leftJoin('T_SLOHEAD', 'TQUO_QUOCD', '=', 'TSLO_QUOCD')
                ->whereNull("TSLO_QUOCD")
                ->where('TQUO_BRANCH', Auth::user()->branch)
                ->groupBy('TQUO_QUOCD')->get();
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
        $doc = base64_decode($request->id);
        $RSHeader = T_QUOHEAD::on($this->dedicatedConnection)->select(
            'MCUS_CUSNM',
            'TQUO_ATTN',
            'MCUS_TELNO',
            'TQUO_SBJCT',
            'TQUO_ISSUDT',
            'TQUO_APPRVDT',
            'TQUO_TYPE',
            'TQUO_SERVTRANS_COST'
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
            'TQUODETA_USAGE',
            'TQUODETA_PRC',
            'TQUODETA_OPRPRC',
            'TQUODETA_MOBDEMOB',
            'TQUODETA_ITMQT',
            'MITM_STKUOM'
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
        $this->fpdf->line(7, 29, 202, 29);

        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->SetXY(7, 31);
        $this->fpdf->Cell(15, 5, 'To', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $MCUS_CUSNM, 0, 0, 'L');
        $this->fpdf->SetXY(7, 36);
        $this->fpdf->Cell(15, 5, 'Attn', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $TQUO_ATTN, 0, 0, 'L');
        $this->fpdf->SetXY(7, 41);
        $this->fpdf->Cell(15, 5, 'Telp', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $MCUS_TELNO, 0, 0, 'L');
        $this->fpdf->SetXY(7, 46);
        $this->fpdf->Cell(15, 5, 'Email', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ':', 0, 0, 'L');
        $this->fpdf->SetXY(7, 51);
        $this->fpdf->Cell(15, 5, 'Subject', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $TQUO_SBJCT, 0, 0, 'L');

        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->SetXY(140, 31);
        $this->fpdf->Cell(15, 5, 'Date', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $TQUO_ISSUDT, 0, 0, 'L');
        $this->fpdf->SetXY(140, 36);
        $this->fpdf->Cell(15, 5, 'Our Ref', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': ' . $doc, 0, 0, 'L');
        $this->fpdf->SetXY(140, 41);
        $this->fpdf->Cell(15, 5, 'From', 0, 0, 'L');
        // $this->fpdf->Cell(5, 5, ': ' . $_COOKIE['JOS_BNM'], 0, 0, 'L');
        $this->fpdf->SetXY(140, 46);
        $this->fpdf->Cell(15, 5, 'Telp', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ':', 0, 0, 'L');
        $this->fpdf->SetXY(140, 51);
        $this->fpdf->Cell(15, 5, 'Fax', 0, 0, 'L');
        $this->fpdf->Cell(5, 5, ': (0711) 5645972', 0, 0, 'L');

        $this->fpdf->SetXY(7, 61);
        $this->fpdf->MultiCell(0, 5, 'Dengan hormat,', 0, 'J');

        if ($RSHeader->TQUO_TYPE === '1') {
            $this->fpdf->SetXY(7, 66);
            $this->fpdf->MultiCell(0, 5, 'Bersama ini kami sampaikan ' . $TQUO_SBJCT . ' dengan data sebagai berikut :', 0, 'J');

            $this->fpdf->SetXY(6, 72);
            $this->fpdf->Cell(20, 5, 'MERK', 1, 0, 'L');
            $this->fpdf->Cell(45, 5, 'CAPACITY', 1, 0, 'L');
            $this->fpdf->Cell(35, 5, 'MODEL', 1, 0, 'C');
            $this->fpdf->Cell(21, 5, 'PEMAKAIAN', 1, 0, 'C');
            $this->fpdf->Cell(25, 5, 'HARGA SEWA', 1, 0, 'C');
            $this->fpdf->Cell(25, 5, 'OPERATOR', 1, 0, 'C');
            $this->fpdf->Cell(20, 5, 'MOBDEMOB', 1, 0, 'C');
            $y = 77;
            foreach ($RSDetail as $r) {
                $this->fpdf->SetXY(6, $y);
                $this->fpdf->Cell(20, 5, $r['MITM_BRAND'], 1, 0, 'L');
                $this->fpdf->Cell(45, 5, $r['MITM_ITMNM'], 1, 0, 'L');
                $ttlwidth = $this->fpdf->GetStringWidth($r['MITM_MODEL']);
                if ($ttlwidth > 35) {
                    $ukuranfont = 8.5;
                    while ($ttlwidth > 35) {
                        $this->fpdf->SetFont('Arial', '', $ukuranfont);
                        $ttlwidth = $this->fpdf->GetStringWidth($r['MITM_MODEL']);
                        $ukuranfont = $ukuranfont - 0.5;
                    }
                }
                $this->fpdf->Cell(35, 5, $r['MITM_MODEL'], 1, 0, 'C');
                $this->fpdf->SetFont('Arial', '', 9);
                $this->fpdf->Cell(21, 5, $r['TQUODETA_USAGE'] . ' Jam', 1, 0, 'C');
                $this->fpdf->Cell(25, 5, number_format($r['TQUODETA_PRC']), 1, 0, 'C');
                $this->fpdf->Cell(25, 5, number_format($r['TQUODETA_OPRPRC']), 1, 0, 'C');
                $this->fpdf->Cell(20, 5, number_format($r['TQUODETA_MOBDEMOB']), 1, 0, 'C');
                $y += 5;
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
            $this->fpdf->MultiCell(0, 5, 'Besar harapan kami penawaran ini dapat menjadi pertimbangan prioritas untuk pengadaan kebutuhan Diesel Genset di Perusahaan Bapak / Ibu
                    Demikian kami sampaikan penawaran ini, dan sambil menunggu kabar lebih lanjut, atas perhatian dan kerjasama yang baik kami ucapkan banyak terima kasih.', 0, 'J');
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
        $y += 25;
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
        $this->fpdf->Cell(20, 5, 'Marketing Dept.', 0, 0, 'L');

        if (!empty($TQUO_APPRVDT)) {
            $this->fpdf->Image(storage_path('app/public/dir_sign.jpg'), 85, $y - 19, 15, 15);
        }
        $this->fpdf->Cell(130, 5, ' Pimpinan,', 0, 0, 'C');
        $this->fpdf->Cell(40, 5, ' Penyewa/pembeli', 0, 0, 'C');
        $this->fpdf->Output('quotation ' . $doc . '.pdf', 'I');


        exit;
    }

    function approve(Request $request)
    {
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        if (in_array($activeRole['code'], ['accounting', 'director'])) {
            $affectedRow = T_QUOHEAD::on($this->dedicatedConnection)
                ->where('TQUO_QUOCD', base64_decode($request->id))
                ->where('TQUO_BRANCH', $request->TQUO_BRANCH)
                ->update([
                    'TQUO_APPRVBY' => Auth::user()->nick_name, 'TQUO_APPRVDT' => date('Y-m-d H:i:s')
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
        if (in_array($activeRole['code'], ['accounting', 'director'])) {
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
        $RS = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::raw("T_QUOHEAD.*,MCUS_CUSNM,TQUODETA_ITMCD,MITM_ITMNM,TQUODETA_ITMQT,TQUODETA_USAGE,TQUODETA_PRC,TQUODETA_OPRPRC,TQUODETA_MOBDEMOB"))
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
        return ['data' => M_Condition::on($this->dedicatedConnection)->select('MCONDITION_DESCRIPTION')->orderBy('MCONDITION_DESCRIPTION')->get()];
    }
}
