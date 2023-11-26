<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroup;
use App\Models\M_CUS;
use App\Models\M_ITM;
use App\Models\M_PCHREQTYPE;
use App\Models\T_PCHORDDETA;
use App\Models\T_PCHORDHEAD;
use App\Models\T_PCHREQDETA;
use App\Models\T_PCHREQHEAD;
use App\Models\T_SLO_DRAFT_DETAIL;
use App\Models\T_SLO_DRAFT_HEAD;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Codedge\Fpdf\Fpdf\Fpdf;

class PurchaseController extends Controller
{
    protected $dedicatedConnection;
    protected $fpdf;
    protected $monthOfRoma = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

    function index()
    {
        return view('transaction.purchase_request', ['types' => M_PCHREQTYPE::on($this->dedicatedConnection)->select(["MPCHREQTYPE_ID", "MPCHREQTYPE_NAME"])->get()]);
    }

    function formOrder()
    {
        return view('transaction.purchase_order');
    }

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
        $this->fpdf = new Fpdf;
    }

    public function save(Request $request)
    {
        if (strlen(trim($request->TPCHREQ_PCHCD)) == 0) {
            // Penyimpanan Baru
            $monthOfRoma = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

            # data quotation header
            $validator = Validator::make($request->all(), [
                'TPCHREQ_PURPOSE' => 'required',
                'TPCHREQ_ISSUDT' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 406);
            }

            $LastLine = DB::connection($this->dedicatedConnection)->table('T_PCHREQHEAD')
                ->whereMonth('created_at', '=', date('m'))
                ->whereYear('created_at', '=', date('Y'))
                ->where('TPCHREQ_BRANCH', Auth::user()->branch)
                ->max('TPCHREQ_LINE');

            $quotationHeader = [];
            $newQuotationCode = '';
            if (!$LastLine) {
                $LastLine = 1;
                $newQuotationCode = '001/PCR/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
            } else {
                $LastLine++;
                $newQuotationCode = substr('00' . $LastLine, -3) . '/PCR/' . $monthOfRoma[date('n') - 1] . '/' . date('Y');
            }
            $quotationHeader = [
                'TPCHREQ_PCHCD' => $newQuotationCode,
                'TPCHREQ_PURPOSE' => $request->TPCHREQ_PURPOSE,
                'TPCHREQ_TYPE' => $request->TPCHREQ_TYPE,
                'TPCHREQ_SUPCD' => $request->TPCHREQ_SUPCD,
                'TPCHREQ_LINE' => $LastLine,
                'TPCHREQ_ISSUDT' => $request->TPCHREQ_ISSUDT,
                'created_by' => Auth::user()->nick_name,
                'TPCHREQ_BRANCH' => Auth::user()->branch
            ];

            # data quotation detail item
            $validator = Validator::make($request->all(), [
                'TPCHREQDETA_ITMCD' => 'required|array',
                'TPCHREQDETA_ITMQT' => 'required|array',
                'TPCHREQDETA_ITMQT.*' => 'required|numeric',
                'TPCHREQDETA_REQDT' => 'required|array',
                'TPCHREQDETA_REQDT.*' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 406);
            }
            $countDetail = count($request->TPCHREQDETA_ITMCD);

            T_PCHREQHEAD::on($this->dedicatedConnection)->create($quotationHeader);
            $quotationDetail = [];
            for ($i = 0; $i < $countDetail; $i++) {
                $quotationDetail[] = [
                    'TPCHREQDETA_PCHCD' => $newQuotationCode,
                    'TPCHREQDETA_ITMCD' => $request->TPCHREQDETA_ITMCD[$i],
                    'TPCHREQDETA_ITMQT' => $request->TPCHREQDETA_ITMQT[$i],
                    'TPCHREQDETA_REQDT' => $request->TPCHREQDETA_REQDT[$i],
                    'TPCHREQDETA_REMARK' => $request->TPCHREQDETA_REMARK[$i],
                    'created_by' => Auth::user()->nick_name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'TPCHREQDETA_BRANCH' => Auth::user()->branch
                ];
            }
            if (!empty($quotationDetail)) {
                T_PCHREQDETA::on($this->dedicatedConnection)->insert($quotationDetail);
            }
            return [
                'msg' => 'OK', 'doc' => $newQuotationCode
            ];
        } else {
            //Penyimpanan tambahan (setelah simpan sebelumnya dan mendapat nomor registrasi dokumen)
            $quotationDetail[] = [
                'TPCHREQDETA_PCHCD' => $request->TPCHREQ_PCHCD,
                'TPCHREQDETA_ITMCD' => $request->TPCHREQDETA_ITMCD,
                'TPCHREQDETA_ITMQT' => $request->TPCHREQDETA_ITMQT,
                'TPCHREQDETA_REQDT' => $request->TPCHREQDETA_REQDT,
                'TPCHREQDETA_REMARK' => $request->TPCHREQDETA_REMARK,
                'TPCHREQDETA_BRANCH' => Auth::user()->branch,
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            T_PCHREQDETA::on($this->dedicatedConnection)->insert($quotationDetail);
            return [
                'msg' => 'OK'
            ];
        }
    }

    public function savePO(Request $request)
    {
        # data header
        $validator = Validator::make($request->all(), [
            'TPCHORD_SUPCD' => 'required',
            'TPCHORD_ATTN' => 'required',
            'TPCHORD_REQCD' => 'required',
            'TPCHORD_ISSUDT' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        # Generate Nomor PO
        $RSAlias = CompanyGroup::select('alias_code')
            ->where('connection', $this->dedicatedConnection)
            ->first();

        $LastLine = DB::connection($this->dedicatedConnection)->table('T_PCHORDHEAD')
            ->whereMonth('created_at', '=', date('m'))
            ->whereYear('created_at', '=', date('Y'))
            ->where('TPCHORD_BRANCH', Auth::user()->branch)
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
            'TPCHORD_ATTN' => $request->TPCHORD_ATTN,
            'TPCHORD_SUPCD' => $request->TPCHORD_SUPCD,
            'TPCHORD_LINE' => $LastLine,
            'TPCHORD_ISSUDT' => $request->TPCHORD_ISSUDT,
            'TPCHORD_REQCD' => $request->TPCHORD_REQCD,
            'created_by' => Auth::user()->nick_name,
            'TPCHORD_BRANCH' => Auth::user()->branch
        ];

        # data detail item
        $validator = Validator::make($request->all(), [
            'TPCHORDDETA_ITMCD' => 'required|array',
            'TPCHORDDETA_ITMQT' => 'required|array',
            'TPCHORDDETA_ITMQT.*' => 'required|numeric',
            'TPCHORDDETA_ITMPRC_PER' => 'required|array',
            'TPCHORDDETA_ITMPRC_PER.*' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        T_PCHORDHEAD::on($this->dedicatedConnection)->create($headerTable);

        $countDetail = count($request->TPCHORDDETA_ITMCD);
        $itemDetail = [];
        for ($i = 0; $i < $countDetail; $i++) {
            $itemDetail[] = [
                'TPCHORDDETA_PCHCD' => $newPOCode,
                'TPCHORDDETA_ITMCD' => $request->TPCHORDDETA_ITMCD[$i],
                'TPCHORDDETA_ITMQT' => $request->TPCHORDDETA_ITMQT[$i],
                'TPCHORDDETA_ITMPRC_PER' => $request->TPCHORDDETA_ITMPRC_PER[$i],
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
                'TPCHORDDETA_BRANCH' => Auth::user()->branch
            ];
        }
        if (!empty($itemDetail)) {
            T_PCHORDDETA::on($this->dedicatedConnection)->insert($itemDetail);
        }

        return [
            'msg' => 'OK', 'doc' => $newPOCode
        ];
    }

    public function update(Request $request)
    {
        # ubah data header
        $affectedRow = T_PCHREQHEAD::on($this->dedicatedConnection)
            ->where('TPCHREQ_PCHCD', base64_decode($request->id))
            ->where('TPCHREQ_BRANCH', Auth::user()->branch)
            ->update([
                'TPCHREQ_PURPOSE' => $request->TPCHREQ_PURPOSE, 'TPCHREQ_ISSUDT' => $request->TPCHREQ_ISSUDT, 'TPCHREQ_TYPE' => $request->TPCHREQ_TYPE, 'TPCHREQ_SUPCD' => $request->TPCHREQ_SUPCD
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    public function updatePODetail(Request $request)
    {
        # ubah data header
        $affectedRow = T_PCHORDDETA::on($this->dedicatedConnection)
            ->where('id', $request->id)
            ->update([
                'TPCHORDDETA_ITMPRC_PER' => $request->TPCHORDDETA_ITMPRC_PER
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'TPCHREQ_PCHCD',
            'TPCHREQ_PURPOSE',
        ];

        if ($request->approval == '1') {
            $RS = T_PCHREQHEAD::on($this->dedicatedConnection)->select(["TPCHREQ_PCHCD", "TPCHREQ_PURPOSE", "TPCHREQ_ISSUDT", "TPCHREQ_TYPE", "MPCHREQTYPE_NAME", "TPCHREQ_SUPCD", "MSUP_SUPNM"])
                ->leftJoin("M_PCHREQTYPE", "TPCHREQ_TYPE", "=", "MPCHREQTYPE_ID")
                ->leftJoin("M_SUP", function ($join) {
                    $join->on("TPCHREQ_SUPCD", "=", "MSUP_SUPCD")
                        ->on('TPCHREQ_BRANCH', '=', 'MSUP_BRANCH');
                })
                ->leftJoin("T_PCHORDHEAD", function ($join) {
                    $join->on("TPCHREQ_PCHCD", "=", "TPCHORD_REQCD")
                        ->on('TPCHREQ_BRANCH', '=', 'TPCHORD_BRANCH');
                })
                ->where('TPCHREQ_TYPE', '1')
                ->whereNull("TPCHORD_REQCD")
                ->where('TPCHREQ_BRANCH', Auth::user()->branch)
                ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
                ->get();
        } else {
            $RS = T_PCHREQHEAD::on($this->dedicatedConnection)->select(["TPCHREQ_PCHCD", "TPCHREQ_PURPOSE", "TPCHREQ_ISSUDT", "TPCHREQ_TYPE", "MPCHREQTYPE_NAME", "TPCHREQ_SUPCD", "MSUP_SUPNM"])
                ->leftJoin("M_PCHREQTYPE", "TPCHREQ_TYPE", "=", "MPCHREQTYPE_ID")
                ->leftJoin("M_SUP", function ($join) {
                    $join->on("TPCHREQ_SUPCD", "=", "MSUP_SUPCD")
                        ->on('TPCHREQ_BRANCH', '=', 'MSUP_BRANCH');
                })
                ->where('TPCHREQ_BRANCH', Auth::user()->branch)
                ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
                ->get();
        }
        return ['data' => $RS];
    }

    function searchPO(Request $request)
    {
        $columnMap = [
            'TPCHORD_PCHCD',
            'MSUP_SUPNM',
        ];

        $RS = T_PCHORDHEAD::on($this->dedicatedConnection)->select(["TPCHORD_PCHCD", "TPCHORD_SUPCD", "MSUP_SUPNM", "TPCHORD_ISSUDT", "TPCHORD_DLVDT", "TPCHORD_REQCD"])
            ->leftJoin("M_SUP", function ($join) {
                $join->on("TPCHORD_SUPCD", "=", "MSUP_SUPCD")
                    ->on('TPCHORD_BRANCH', '=', 'MSUP_BRANCH');
            })
            ->where('TPCHORD_BRANCH', Auth::user()->branch)
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->get();

        return ['data' => $RS];
    }

    function loadById(Request $request)
    {
        $RS = T_PCHREQDETA::on($this->dedicatedConnection)->select(["id", "TPCHREQDETA_ITMCD", "MITM_ITMNM", "TPCHREQDETA_ITMQT", "TPCHREQDETA_REQDT", "TPCHREQDETA_REMARK"])
            ->leftJoin("M_ITM", function ($join) {
                $join->on("TPCHREQDETA_ITMCD", "=", "MITM_ITMCD")
                    ->on('TPCHREQDETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->where('TPCHREQDETA_PCHCD', base64_decode($request->id))
            ->where('TPCHREQDETA_BRANCH', Auth::user()->branch)
            ->whereNull('deleted_at')->get();
        return ['dataItem' => $RS];
    }
    function loadByIdApproval(Request $request)
    {
        $RS = T_PCHREQDETA::on($this->dedicatedConnection)->select(["id", "TPCHREQDETA_ITMCD", "MITM_ITMNM", "TPCHREQDETA_ITMQT", "TPCHREQDETA_REQDT", "TPCHREQDETA_REMARK"])
            ->leftJoin("M_ITM", function ($join) {
                $join->on("TPCHREQDETA_ITMCD", "=", "MITM_ITMCD")
                    ->on('TPCHREQDETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->where('TPCHREQDETA_PCHCD', base64_decode($request->id))
            ->where('TPCHREQDETA_BRANCH', $request->TPCHREQDETA_BRANCH)
            ->whereNull('deleted_at')->get();
        return ['dataItem' => $RS];
    }

    function loadPOById(Request $request)
    {
        $RS = T_PCHORDDETA::on($this->dedicatedConnection)->select(["id", "TPCHORDDETA_ITMCD", "MITM_ITMNM", "TPCHORDDETA_ITMQT", "TPCHORDDETA_ITMPRC_PER"])
            ->leftJoin("M_ITM", function ($join) {
                $join->on("TPCHORDDETA_ITMCD", "=", "MITM_ITMCD")
                    ->on('TPCHORDDETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->where('TPCHORDDETA_PCHCD', base64_decode($request->id))
            ->where('TPCHORDDETA_BRANCH', Auth::user()->branch)
            ->whereNull('deleted_at')->get();
        return ['dataItem' => $RS];
    }
    function loadPOByIdApproval(Request $request)
    {
        $RS = T_PCHORDDETA::on($this->dedicatedConnection)->select(["id", "TPCHORDDETA_ITMCD", "MITM_ITMNM", "TPCHORDDETA_ITMQT", "TPCHORDDETA_ITMPRC_PER"])
            ->leftJoin("M_ITM", function ($join) {
                $join->on("TPCHORDDETA_ITMCD", "=", "MITM_ITMCD")
                    ->on('TPCHORDDETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->where('TPCHORDDETA_PCHCD', base64_decode($request->id))
            ->where('TPCHORDDETA_BRANCH', $request->TPCHORDDETA_BRANCH)
            ->whereNull('deleted_at')->get();
        return ['dataItem' => $RS];
    }

    function deleteItemById(Request $request)
    {
        $affectedRow = T_PCHREQDETA::on($this->dedicatedConnection)->where('id', $request->id)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::user()->nick_name
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'could not be deleted', 'affectedRow' => $affectedRow];
    }

    public function toPDF(Request $request)
    {
        $doc = base64_decode($request->id);
        $RSHeader = T_PCHREQHEAD::on($this->dedicatedConnection)->select('TPCHREQ_PURPOSE', 'TPCHREQ_ISSUDT', 'TPCHREQ_APPRVBY')
            ->where("TPCHREQ_PCHCD", $doc)
            ->where('TPCHREQ_BRANCH', Auth::user()->branch)
            ->get()->toArray();
        $TPCHREQ_PURPOSE = '';
        $TPCHREQ_ISSUDT = '';
        $TPCHREQ_APPRVBY = '';
        foreach ($RSHeader as $r) {
            $TPCHREQ_PURPOSE = $r['TPCHREQ_PURPOSE'];
            $_ISSUDT = explode('-', $r['TPCHREQ_ISSUDT']);
            $TPCHREQ_ISSUDT = $_ISSUDT[2] . '/' . $_ISSUDT[1] . '/' . $_ISSUDT[0];
            $TPCHREQ_APPRVBY = $r['TPCHREQ_APPRVBY'];
        }

        $RSDetail = T_PCHREQDETA::on($this->dedicatedConnection)->select('TPCHREQDETA_ITMCD', 'MITM_BRAND', 'MITM_ITMNM', 'MITM_MODEL', 'TPCHREQDETA_ITMQT', 'TPCHREQDETA_REQDT', 'TPCHREQDETA_REMARK')
            ->leftJoin("M_ITM", function ($join) {
                $join->on("TPCHREQDETA_ITMCD", "=", "MITM_ITMCD")
                    ->on("TPCHREQDETA_BRANCH", "=", "MITM_BRANCH");
            })
            ->whereNull("deleted_at")
            ->where('TPCHREQDETA_BRANCH', Auth::user()->branch)
            ->where("TPCHREQDETA_PCHCD", $doc)
            ->get()->toArray();

        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->AddPage("L", 'A5');
        $this->fpdf->SetXY(7, 5);
        $this->fpdf->Cell(0, 8, 'BUKTI PERMINTAAN BARANG', 0, 0, 'C');
        $this->fpdf->SetFont('Arial', 'I', 11);
        $this->fpdf->SetXY(7, 10);
        $this->fpdf->Cell(10, 8, 'Untuk Keperluan : ' . $TPCHREQ_PURPOSE, 0, 0);

        $this->fpdf->SetXY(7, 15);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(10, 8, 'Tanggal : ' . $TPCHREQ_ISSUDT, 0, 0);

        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->SetXY(6, 25);
        $this->fpdf->Cell(10, 5, 'No', 1, 0, 'L');
        $this->fpdf->Cell(85, 5, 'Nama Barang', 1, 0, 'L');
        $this->fpdf->Cell(20, 5, 'Jumlah', 1, 0, 'C');
        $this->fpdf->Cell(40, 5, 'Tgl. Permintaan', 1, 0, 'C');
        $this->fpdf->Cell(40, 5, 'Keterangan', 1, 0, 'C');

        $y = 30;
        $nomor = 1;
        $this->fpdf->SetFont('Arial', '', 10);
        foreach ($RSDetail as $r) {
            $this->fpdf->SetXY(6, $y);
            $this->fpdf->Cell(10, 5, $nomor++, 1, 0, 'L');
            $this->fpdf->Cell(85, 5, $r['MITM_ITMNM'], 1, 0, 'L');
            $this->fpdf->Cell(20, 5, $r['TPCHREQDETA_ITMQT'], 1, 0, 'C');
            $this->fpdf->Cell(40, 5, $r['TPCHREQDETA_REQDT'], 1, 0, 'C');
            $this->fpdf->Cell(40, 5, $r['TPCHREQDETA_REMARK'], 1, 0, 'C');
            $y += 5;
        }

        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY($this->fpdf->GetPageWidth() - 70, $this->fpdf->GetPageHeight() - 35);
        $this->fpdf->Cell(20, 5, 'Palembang', 0, 0, 'L');
        $this->fpdf->SetXY(6, $this->fpdf->GetPageHeight() - 30);
        $this->fpdf->Cell(20, 5, 'Disetujui', 0, 0, 'L');
        $this->fpdf->SetXY($this->fpdf->GetPageWidth() - 70, $this->fpdf->GetPageHeight() - 30);
        $this->fpdf->Cell(20, 5, 'Hormat Kami', 0, 0, 'L');


        $this->fpdf->Output('purchase request ' . $doc . '.pdf', 'I');


        exit;
    }

    public function POtoPDF(Request $request)
    {
        $doc = base64_decode($request->id);
        $RSCG = CompanyGroup::select('name', 'address', 'phone', 'fax')
            ->where('connection', $this->dedicatedConnection)
            ->first();
        $RSHeader = T_PCHORDHEAD::on($this->dedicatedConnection)->select('T_PCHORDHEAD.created_by', 'TPCHORD_ISSUDT', 'TPCHORD_APPRVBY', 'MSUP_SUPNM', 'MSUP_ADDR1', 'MSUP_TELNO', 'MSUP_TAXREG')
            ->leftJoin('M_SUP', function ($join) {
                $join->on('TPCHORD_SUPCD', '=', 'MSUP_SUPCD')
                    ->on('TPCHORD_BRANCH', '=', 'MSUP_BRANCH');
            })
            ->where("TPCHORD_PCHCD", $doc)
            ->where('TPCHORD_BRANCH', Auth::user()->branch)
            ->get()->toArray();
        $created_by = '';
        $TPCHORD_ISSUDT = '';
        $TPCHORD_APPRVBY = '';
        $MSUP_SUPNM = '';
        $MSUP_ADDR1 = '';
        $MSUP_TELNO = '';
        $MSUP_TAXREG = '';
        foreach ($RSHeader as $r) {
            $created_by = $r['created_by'];
            $_ISSUDT = date_create($r['TPCHORD_ISSUDT']);
            $TPCHORD_ISSUDT = date_format($_ISSUDT, 'd-M-Y');
            $TPCHORD_APPRVBY = $r['TPCHORD_APPRVBY'];
            $MSUP_SUPNM = $r['MSUP_SUPNM'];
            $MSUP_ADDR1 = $r['MSUP_ADDR1'];
            $MSUP_TELNO = $r['MSUP_TELNO'];
            $MSUP_TAXREG = $r['MSUP_TAXREG'];
        }
        $RSUserWhoPrepare = User::select('name')->whereIn('nick_name', [$created_by])->first();

        $RSDetail = T_PCHORDDETA::on($this->dedicatedConnection)->select('TPCHORDDETA_ITMCD', 'MITM_BRAND', 'MITM_ITMNM', 'MITM_MODEL', 'TPCHORDDETA_ITMQT', 'TPCHORDDETA_ITMPRC_PER', 'MITM_STKUOM')
            ->leftJoin("M_ITM", function ($join) {
                $join->on("TPCHORDDETA_ITMCD", "=", "MITM_ITMCD")
                    ->on('TPCHORDDETA_BRANCH', '=', 'MITM_BRANCH');
            })
            ->whereNull("deleted_at")
            ->where("TPCHORDDETA_PCHCD", $doc)
            ->get()->toArray();

        $this->fpdf->SetFont('Arial', 'B', 18);
        $this->fpdf->AddPage("L", 'A5');
        $this->fpdf->SetXY(7, 5);
        $this->fpdf->Cell(0, 8, $RSCG->name, 0, 0, 'C');
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->SetXY(3, 12);
        $this->fpdf->MultiCell(0, 4, $RSCG->address, 0, 'C');
        $this->fpdf->SetXY(3, 17);
        $this->fpdf->MultiCell(0, 4, 'Telp.' . $RSCG->phone . ' - Fax ' . $RSCG->fax, 0, 'C');
        $this->fpdf->Line(3, 22, 205, 22);

        $this->fpdf->SetFont('Arial', 'BU', 12);
        $this->fpdf->SetXY(3, 24);
        $this->fpdf->MultiCell(0, 4, 'Purchase Order', 0, 'C');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(3, 28);
        $this->fpdf->MultiCell(0, 4, 'PO No. : ' . $doc, 0, 'C');

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(3, 32);
        $this->fpdf->MultiCell(19, 4, 'Vendor', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(22, 32);
        $this->fpdf->MultiCell(100, 4, ': ' . $MSUP_SUPNM, 0);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(3, 36);
        $this->fpdf->MultiCell(19, 4, 'Address', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(22, 36);
        $this->fpdf->MultiCell(100, 4, ': ' . $MSUP_ADDR1, 0);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(3, 40);
        $this->fpdf->MultiCell(19, 4, 'Phone/fax', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(22, 40);
        $this->fpdf->MultiCell(100, 4, ': ' . $MSUP_TELNO, 0);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(3, 44);
        $this->fpdf->MultiCell(19, 4, 'Attn', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(22, 44);
        $this->fpdf->MultiCell(100, 4, ': -', 0);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(123, 32);
        $this->fpdf->MultiCell(25, 4, 'Date', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(123 + 25, 32);
        $this->fpdf->MultiCell(50, 4, ': ' . $TPCHORD_ISSUDT, 0);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(123, 36);
        $this->fpdf->MultiCell(25, 4, 'PR. No', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(123 + 25, 36);
        $this->fpdf->MultiCell(50, 4, ': ', 0);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(123, 40);
        $this->fpdf->MultiCell(25, 4, 'Delivery Date', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(123 + 25, 40);
        $this->fpdf->MultiCell(50, 4, ': ', 0);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(123, 44);
        $this->fpdf->MultiCell(25, 4, 'NPWP', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(123 + 25, 44);
        $this->fpdf->MultiCell(50, 4, ': ' . $MSUP_TAXREG, 0);


        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(3, 50);
        $this->fpdf->Cell(10, 5, 'No', 1, 0, 'L');
        $this->fpdf->Cell(85, 5, 'Item Description', 1, 0, 'L');
        $this->fpdf->Cell(15, 5, 'Qty', 1, 0, 'C');
        $this->fpdf->Cell(15, 5, 'Unit', 1, 0, 'C');
        $this->fpdf->Cell(35, 5, 'Unit Price', 1, 0, 'C');
        $this->fpdf->Cell(35, 5, 'Line Total', 1, 0, 'C');

        $y = 55;
        $nomor = 1;
        $grandTotal = 0;
        $subTotal = 0;
        $this->fpdf->SetFont('Arial', '', 10);
        foreach ($RSDetail as $r) {
            $lineTotal = $r['TPCHORDDETA_ITMPRC_PER'] * $r['TPCHORDDETA_ITMQT'];
            $this->fpdf->SetXY(3, $y);
            $this->fpdf->Cell(10, 5, $nomor++, 1, 0, 'L');
            $this->fpdf->Cell(85, 5, $r['MITM_ITMNM'], 1, 0, 'L');
            $this->fpdf->Cell(15, 5, $r['TPCHORDDETA_ITMQT'], 1, 0, 'C');
            $this->fpdf->Cell(15, 5, $r['MITM_STKUOM'], 1, 0, 'C');
            $this->fpdf->Cell(35, 5, number_format($r['TPCHORDDETA_ITMPRC_PER']), 1, 0, 'R');
            $this->fpdf->Cell(35, 5, number_format($lineTotal), 1, 0, 'R');
            $subTotal += $lineTotal;
            $y += 5;
        }
        $vat = strlen($MSUP_TAXREG) !== 0 ? 11 / 100 : 0;
        $vatValue = $subTotal * $vat;
        $grandTotal = $vatValue + $subTotal;
        $this->fpdf->SetXY(3, $y);
        $this->fpdf->SetFont('Arial', 'I', 10);
        $this->fpdf->MultiCell(125, 15, 'Say ' . ucwords($this->numberToSentence($grandTotal)), 1);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(128, $y);
        $this->fpdf->Cell(35, 5, 'Sub total', 1, 0);
        $this->fpdf->Cell(35, 5, number_format($subTotal), 1, 0, 'R');
        $y += 5;
        $this->fpdf->SetXY(128, $y);
        $this->fpdf->Cell(35, 5, 'VAT/PPN', 1, 0);
        $this->fpdf->Cell(35, 5, number_format($vatValue), 1, 0, 'R');
        $y += 5;
        $this->fpdf->SetXY(128, $y);
        $this->fpdf->Cell(35, 5, 'Total', 1, 0);
        $this->fpdf->Cell(35, 5, number_format($grandTotal), 1, 0, 'R');
        $y += 5;
        $this->fpdf->SetXY(3, $y);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell(10, 5, 'Note', 0);
        $y += 5;
        $this->fpdf->SetXY(3 + 10, $y);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell(150, 5, '1. Semua pengiriman barang harus disertakan nota/faktur/kwitansi', 0);
        $y += 5;
        $this->fpdf->SetXY(3 + 10, $y);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell(150, 5, '2. Barang akan kami kembalikan apabila tidak sesuai pesanan', 0);
        $y += 5;
        $this->fpdf->SetXY(3 + 10, $y);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell(150, 5, '3. Nomor Purchase Order (PO) harus dicantumkan dalam nota/faktur/kwitansi', 0);

        $y += 5;
        $this->fpdf->SetXY(90, $y);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell(27, 5, 'Order By', 1, 'C');
        $this->fpdf->SetXY(90 + 27, $y);
        $this->fpdf->MultiCell(27, 5, 'Prepared By', 1, 'C');
        $this->fpdf->SetXY(90 + 27 + 27, $y);
        $this->fpdf->MultiCell(27, 5, 'Approved By', 1, 'C');
        $this->fpdf->SetXY(90 + 27 + 27 + 27, $y);
        $this->fpdf->MultiCell(27, 5, 'Confirmed By', 1, 'C');

        $y += 5;
        $this->fpdf->SetXY(90, $y);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell(27, 15, '', 1, 'C');
        $this->fpdf->SetXY(90 + 27, $y);
        $this->fpdf->MultiCell(27, 15, '', 1, 'C');
        $this->fpdf->SetXY(90 + 27 + 27, $y);
        $this->fpdf->MultiCell(27, 15, '', 1, 'C');
        $this->fpdf->SetXY(90 + 27 + 27 + 27, $y);
        $this->fpdf->MultiCell(27, 15, '', 1, 'C');

        $y += 15;
        $this->fpdf->SetXY(90, $y);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell(27, 5, '', 1, 'C');
        $this->fpdf->SetXY(90 + 27, $y);
        $this->fpdf->MultiCell(27, 5, $RSUserWhoPrepare->name, 1, 'C');
        $this->fpdf->SetXY(90 + 27 + 27, $y);
        $this->fpdf->MultiCell(27, 5, '', 1, 'C');
        $this->fpdf->SetXY(90 + 27 + 27 + 27, $y);
        $this->fpdf->MultiCell(27, 5, '', 1, 'C');

        $this->fpdf->Output('purchase order ' . $doc . '.pdf', 'I');

        exit;
    }

    public function formApproval()
    {
        return view('transaction.purchase_request_approval');
    }

    public function formApprovalPO()
    {
        return view('transaction.purchase_order_approval');
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

    function notifications()
    {
        $dataPurchaseRequestTobeUpproved = [];
        $dataPurchaseRequestApproved = [];
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        if (in_array($activeRole['code'], ['accounting', 'director', 'manager', 'general_manager'])) {
            # Query untuk data Purchase Request dengan tipe "Normal" 
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_PCHREQDETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TPCHREQDETA_PCHCD,TPCHREQDETA_BRANCH")
                ->groupBy("TPCHREQDETA_PCHCD", "TPCHREQDETA_BRANCH")
                ->whereNull('deleted_at');
            $dataPurchaseRequestTobeUpproved = T_PCHREQHEAD::on($this->dedicatedConnection)->select(DB::raw("TPCHREQ_PCHCD,max(TTLDETAIL) TTLDETAIL, max(T_PCHREQHEAD.created_at) CREATED_AT,max(TPCHREQ_PURPOSE) TPCHREQ_PURPOSE,TPCHREQ_BRANCH"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TPCHREQ_PCHCD", "=", "TPCHREQDETA_PCHCD")
                        ->on('TPCHREQ_BRANCH', '=', 'TPCHREQDETA_BRANCH');
                })
                ->whereNull("TPCHREQ_APPRVDT")
                ->whereNull("TPCHREQ_REJCTDT")
                ->where("TPCHREQ_TYPE", '2')
                ->groupBy('TPCHREQ_PCHCD', 'TPCHREQ_BRANCH')->get();
        }
        if (in_array($activeRole['code'], ['purchasing'])) {
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_PCHREQDETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TPCHREQDETA_PCHCD, TPCHREQDETA_BRANCH")
                ->groupBy("TPCHREQDETA_PCHCD", "TPCHREQDETA_BRANCH")
                ->whereNull('deleted_at');
            $dataPurchaseRequestApproved = T_PCHREQHEAD::on($this->dedicatedConnection)->select(DB::raw("TPCHREQ_PCHCD,max(TTLDETAIL) TTLDETAIL, max(T_PCHREQHEAD.created_at) CREATED_AT,max(TPCHREQ_PURPOSE) TPCHREQ_PURPOSE, max(TPCHREQ_REJCTDT) TPCHREQ_REJCTDT, max(TPCHREQ_APPRVDT) TPCHREQ_APPRVDT,MPCHREQTYPE_NAME,TPCHREQ_TYPE"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TPCHREQ_PCHCD", "=", "TPCHREQDETA_PCHCD")
                        ->on('TPCHREQ_BRANCH', '=', 'TPCHREQDETA_BRANCH');
                })
                ->leftJoin("M_PCHREQTYPE", "TPCHREQ_TYPE", "=", "MPCHREQTYPE_ID")
                ->leftJoin('T_PCHORDHEAD', function ($join) {
                    $join->on('TPCHREQ_PCHCD', '=', 'TPCHORD_REQCD')
                        ->on('TPCHREQ_BRANCH', '=', 'TPCHORD_BRANCH');
                })
                ->whereNull('TPCHORD_REQCD')
                ->where('TPCHREQ_BRANCH', Auth::user()->branch)
                ->groupBy('TPCHREQ_PCHCD', 'MPCHREQTYPE_NAME', 'TPCHREQ_TYPE', 'TPCHREQ_BRANCH')->get();
        }
        return [
            'data' => $dataPurchaseRequestTobeUpproved, 'dataApproved' => $dataPurchaseRequestApproved
        ];
    }

    function notificationsPO()
    {
        $data = [];
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        if (in_array($activeRole['code'], ['accounting', 'director', 'general_manager'])) {
            # Query untuk data Purchase Order
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_PCHORDDETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TPCHORDDETA_PCHCD, TPCHORDDETA_BRANCH")
                ->groupBy("TPCHORDDETA_PCHCD", 'TPCHORDDETA_BRANCH')
                ->whereNull('deleted_at');
            $data = T_PCHORDHEAD::on($this->dedicatedConnection)->select(DB::raw("TPCHORD_PCHCD,max(TTLDETAIL) TTLDETAIL, max(T_PCHORDHEAD.created_at) CREATED_AT, MAX(MSUP_SUPNM) MSUP_SUPNM,TPCHORD_BRANCH"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TPCHORD_PCHCD", "=", "TPCHORDDETA_PCHCD")
                        ->on('TPCHORD_BRANCH', '=', 'TPCHORDDETA_BRANCH');
                })
                ->leftJoin('M_SUP', function ($join) {
                    $join->on('TPCHORD_SUPCD', '=', 'MSUP_SUPCD')
                        ->on('TPCHORD_BRANCH', '=', 'MSUP_BRANCH');
                })
                ->whereNull("TPCHORD_APPRVDT")
                ->whereNull("TPCHORD_REJCTBY")
                ->groupBy('TPCHORD_PCHCD', 'TPCHORD_BRANCH')->get();
        }
        return [
            'data' => $data
        ];
    }

    function approve(Request $request)
    {
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        if (in_array($activeRole['code'], ['accounting', 'director', 'general_manager'])) {
            $PRCode = base64_decode($request->id);
            $RSPR = T_PCHREQHEAD::on($this->dedicatedConnection)->select('TPCHREQ_SUPCD', 'MSUP_CGCON')
                ->leftJoin('M_SUP', function ($join) {
                    $join->on('TPCHREQ_SUPCD', '=', 'MSUP_SUPCD')
                        ->on('TPCHREQ_BRANCH', '=', 'MSUP_BRANCH');
                })
                ->where('TPCHREQ_PCHCD', $PRCode)
                ->where('TPCHREQ_BRANCH', $request->TPCHREQ_BRANCH)
                ->first();

            # Periksa registrasi CG aktif di CG tujuan pada Customer Master
            $RSCGActiveAsCustomer = M_CUS::on($RSPR->MSUP_CGCON)->select('MCUS_CUSCD')
                ->where('MCUS_CGCON', $this->dedicatedConnection)->first();

            if (empty($RSCGActiveAsCustomer)) {
                return response()->json(['message' => 'please register current company as their customer connection'], 403);
            }

            # registrasi Item (jika belum ada) di CG tujuan pada Item Master
            $RSPRDetail = T_PCHREQDETA::on($this->dedicatedConnection)->select('TPCHREQDETA_ITMQT', 'M_ITM.*')
                ->leftJoin('M_ITM', function ($join) {
                    $join->on('TPCHREQDETA_ITMCD', '=', 'MITM_ITMCD')
                        ->on('TPCHREQDETA_BRANCH', '=', 'MITM_BRANCH');
                })
                ->where('TPCHREQDETA_PCHCD', $PRCode)
                ->where('TPCHREQDETA_BRANCH', $request->TPCHREQ_BRANCH)
                ->whereNull('deleted_at')
                ->get();
            foreach ($RSPRDetail as $r) {
                $totalRow = M_ITM::on($RSPR->MSUP_CGCON)
                    ->where('MITM_ITMCD', $r->MITM_ITMCD)
                    ->where('MITM_BRANCH', $r->MITM_BRANCH)
                    ->count();
                if ($totalRow === 0) {
                    M_ITM::on($RSPR->MSUP_CGCON)->create([
                        'MITM_ITMCD' => $r->MITM_ITMCD,
                        'MITM_ITMNM' => $r->MITM_ITMNM,
                        'MITM_STKUOM' => $r->MITM_STKUOM,
                        'MITM_ITMTYPE' => $r->MITM_ITMTYPE,
                        'MITM_BRAND' => $r->MITM_BRAND,
                        'MITM_MODEL' => $r->MITM_MODEL,
                        'MITM_SPEC' => $r->MITM_SPEC,
                        'MITM_ITMCAT' => $r->MITM_ITMCAT,
                        'MITM_COACD' => $r->MITM_COACD,
                        'MITM_BRANCH' => $r->MITM_BRANCH,
                    ]);
                }
            }

            $affectedRow = T_PCHREQHEAD::on($this->dedicatedConnection)
                ->where('TPCHREQ_PCHCD', $PRCode)
                ->where('TPCHREQ_BRANCH', $request->TPCHREQ_BRANCH)
                ->update([
                    'TPCHREQ_APPRVBY' => Auth::user()->nick_name, 'TPCHREQ_APPRVDT' => date('Y-m-d H:i:s')
                ]);
            if ($affectedRow) {

                # Generate Nomor PO
                $RSAlias = CompanyGroup::select('alias_code')
                    ->where('connection', $this->dedicatedConnection)
                    ->first();

                $LastLine = DB::connection($this->dedicatedConnection)->table('T_PCHORDHEAD')
                    ->whereMonth('created_at', '=', date('m'))
                    ->whereYear('created_at', '=', date('Y'))
                    ->whereYear('TPCHORD_BRANCH', '=', $request->TPCHREQ_BRANCH)
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
                    'TPCHORD_SUPCD' => $RSPR->TPCHREQ_SUPCD,
                    'TPCHORD_LINE' => $LastLine,
                    'TPCHORD_ISSUDT' => date('Y-m-d'),
                    'TPCHORD_APPRVBY' => Auth::user()->nick_name,
                    'TPCHORD_APPRVDT' => date('Y-m-d H:i:s'),
                    'TPCHORD_REQCD' => $PRCode,
                    'created_by' => Auth::user()->nick_name,
                    'TPCHORD_BRANCH' => $request->TPCHREQ_BRANCH,
                ];

                $detailTable = [];
                foreach ($RSPRDetail as $r) {
                    $detailTable[] = [
                        'TPCHORDDETA_PCHCD' => $newPOCode,
                        'TPCHORDDETA_ITMCD' => $r->MITM_ITMCD,
                        'TPCHORDDETA_ITMQT' => $r->TPCHREQDETA_ITMQT,
                        'TPCHORDDETA_ITMPRC_PER' => 0,
                        'created_by' => Auth::user()->nick_name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'TPCHORDDETA_BRANCH' => $request->TPCHREQ_BRANCH,
                    ];
                }

                # Simpan data ke Tabel PO Header
                T_PCHORDHEAD::on($this->dedicatedConnection)->create($headerTable);

                # Simpan data ke Tabel PO Detail
                T_PCHORDDETA::on($this->dedicatedConnection)->insert($detailTable);

                # Generate Sales Order Draft di CG tujuan
                $LastLine = DB::connection($RSPR->MSUP_CGCON)->table('T_SLO_DRAFT_HEAD')
                    ->whereMonth('created_at', '=', date('m'))
                    ->whereYear('created_at', '=', date('Y'))
                    ->whereYear('TSLODRAFT_BRANCH', '=', $request->TPCHREQ_BRANCH)
                    ->max('TSLODRAFT_LINE');

                $newDocumentCode = '';
                if (!$LastLine) {
                    $LastLine = 1;
                    $newDocumentCode = '001/SOD/' . $this->monthOfRoma[date('n') - 1] . '/' . date('Y');
                } else {
                    $LastLine++;
                    $newDocumentCode = substr('00' . $LastLine, -3) . '/SOD/' . $this->monthOfRoma[date('n') - 1] . '/' . date('Y');
                }
                $headerTable = [
                    'TSLODRAFT_SLOCD' => $newDocumentCode,
                    'TSLODRAFT_CUSCD' => $RSCGActiveAsCustomer->MCUS_CUSCD,
                    'TSLODRAFT_LINE' => $LastLine,
                    'TSLODRAFT_ATTN' => '-',
                    'TSLODRAFT_POCD' => $newPOCode,
                    'TSLODRAFT_ISSUDT' => date('Y-m-d'),
                    'created_by' => Auth::user()->nick_name,
                    'TSLODRAFT_BRANCH' => $request->TPCHREQ_BRANCH,
                ];

                # Simpan data ke Tabel RO Header di CG tujuan
                T_SLO_DRAFT_HEAD::on($RSPR->MSUP_CGCON)->create($headerTable);

                # Simpan data ke Tabel RO Detail di CG tujuan
                $detailTable = [];
                foreach ($RSPRDetail as $r) {
                    $detailTable[] = [
                        'TSLODRAFTDETA_SLOCD' => $newDocumentCode,
                        'TSLODRAFTDETA_ITMCD' => $r->MITM_ITMCD,
                        'TSLODRAFTDETA_ITMQT' => $r->TPCHREQDETA_ITMQT,
                        'TSLODRAFTDETA_ITMPRC_PER' => 0,
                        'created_by' => Auth::user()->nick_name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'TSLODRAFTDETA_BRANCH' => $request->TPCHREQ_BRANCH,
                    ];
                }
                T_SLO_DRAFT_DETAIL::on($RSPR->MSUP_CGCON)->insert($detailTable);
                $message = 'Approved';
            } else {
                $message =  'Something wrong please contact admin';
            }

            return ['message' => $message];
        } else {
            return response()->json(['message' => 'forbidden'], 403);
        }
    }

    function approvePO(Request $request)
    {
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        if (in_array($activeRole['code'], ['accounting', 'director', 'general_manager'])) {
            $affectedRow = T_PCHORDHEAD::on($this->dedicatedConnection)
                ->where('TPCHORD_PCHCD', base64_decode($request->id))
                ->where('TPCHORD_BRANCH', $request->TPCHORD_BRANCH)
                ->update([
                    'TPCHORD_APPRVBY' => Auth::user()->nick_name, 'TPCHORD_APPRVDT' => date('Y-m-d H:i:s')
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
        if (in_array($activeRole['code'], ['accounting', 'director', 'general_manager'])) {
            $affectedRow = T_PCHREQHEAD::on($this->dedicatedConnection)
                ->where('TPCHREQ_PCHCD', base64_decode($request->id))
                ->where('TPCHREQ_BRANCH', $request->TPCHREQ_BRANCH)
                ->update([
                    'TPCHREQ_REJCTBY' => Auth::user()->nick_name, 'TPCHREQ_REJCTDT' => date('Y-m-d H:i:s')
                ]);
            $message = $affectedRow ? 'Approved' : 'Something wrong please contact admin';
            return ['message' => $message];
        } else {
            return response()->json(['message' => 'forbidden'], 403);
        }
    }

    function rejectPO(Request $request)
    {
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        if (in_array($activeRole['code'], ['accounting', 'director', 'general_manager'])) {
            $affectedRow = T_PCHORDHEAD::on($this->dedicatedConnection)
                ->where('TPCHORD_PCHCD', base64_decode($request->id))
                ->where('TPCHORD_BRANCH', $request->TPCHORD_BRANCH)
                ->update([
                    'TPCHORD_REJCTBY' => Auth::user()->nick_name, 'TPCHORD_REJCTDT' => date('Y-m-d H:i:s')
                ]);
            $message = $affectedRow ? 'Approved' : 'Something wrong please contact admin';
            return ['message' => $message];
        } else {
            return response()->json(['message' => 'forbidden'], 403);
        }
    }

    function formStatus()
    {
        return view('transaction.purchase_request_status');
    }
}
