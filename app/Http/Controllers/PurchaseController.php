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
            ];

            T_PCHREQHEAD::on($this->dedicatedConnection)->create($quotationHeader);

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
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            T_PCHREQDETA::on($this->dedicatedConnection)->insert($quotationDetail);
            return [
                'msg' => 'OK'
            ];
        }
    }

    public function update(Request $request)
    {
        # ubah data header
        $affectedRow = T_PCHREQHEAD::on($this->dedicatedConnection)->where('TPCHREQ_PCHCD', base64_decode($request->id))
            ->update([
                'TPCHREQ_PURPOSE' => $request->TPCHREQ_PURPOSE, 'TPCHREQ_ISSUDT' => $request->TPCHREQ_ISSUDT, 'TPCHREQ_TYPE' => $request->TPCHREQ_TYPE, 'TPCHREQ_SUPCD' => $request->TPCHREQ_SUPCD
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'TPCHREQ_PCHCD',
            'TPCHREQ_PURPOSE',
        ];

        $RS = T_PCHREQHEAD::on($this->dedicatedConnection)->select(["TPCHREQ_PCHCD", "TPCHREQ_PURPOSE", "TPCHREQ_ISSUDT", "TPCHREQ_TYPE", "MPCHREQTYPE_NAME", "TPCHREQ_SUPCD", "MSUP_SUPNM"])
            ->leftJoin("M_PCHREQTYPE", "TPCHREQ_TYPE", "=", "MPCHREQTYPE_ID")
            ->leftJoin("M_SUP", "TPCHREQ_SUPCD", "=", "MSUP_SUPCD")
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->get();
        return ['data' => $RS];
    }

    function loadById(Request $request)
    {
        $RS = T_PCHREQDETA::on($this->dedicatedConnection)->select(["id", "TPCHREQDETA_ITMCD", "MITM_ITMNM", "TPCHREQDETA_ITMQT", "TPCHREQDETA_REQDT", "TPCHREQDETA_REMARK"])
            ->leftJoin("M_ITM", "TPCHREQDETA_ITMCD", "=", "MITM_ITMCD")
            ->where('TPCHREQDETA_PCHCD', base64_decode($request->id))
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
            ->leftJoin("M_ITM", "TPCHREQDETA_ITMCD", "=", "MITM_ITMCD")
            ->whereNull("deleted_at")
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

    public function formApproval()
    {
        return view('transaction.purchase_request_approval');
    }

    function notifications()
    {
        $dataPurchaseRequestTobeUpproved = [];
        $dataPurchaseRequestApproved = [];
        if (in_array(Auth::user()->role, ['accounting', 'director'])) {
            # Query untuk data Purchase Request dengan tipe "Normal" 
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_PCHREQDETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TPCHREQDETA_PCHCD")
                ->groupBy("TPCHREQDETA_PCHCD")
                ->whereNull('deleted_at');
            $dataPurchaseRequestTobeUpproved = T_PCHREQHEAD::on($this->dedicatedConnection)->select(DB::raw("TPCHREQ_PCHCD,max(TTLDETAIL) TTLDETAIL, max(T_PCHREQHEAD.created_at) CREATED_AT,max(TPCHREQ_PURPOSE) TPCHREQ_PURPOSE"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TPCHREQ_PCHCD", "=", "TPCHREQDETA_PCHCD");
                })
                ->whereNull("TPCHREQ_APPRVDT")
                ->whereNull("TPCHREQ_REJCTDT")
                ->where("TPCHREQ_TYPE", '2')
                ->groupBy('TPCHREQ_PCHCD')->get();
        }
        if (in_array(Auth::user()->role, ['purchasing'])) {
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_PCHREQDETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TPCHREQDETA_PCHCD")
                ->groupBy("TPCHREQDETA_PCHCD")
                ->whereNull('deleted_at');
            $dataPurchaseRequestApproved = T_PCHREQHEAD::on($this->dedicatedConnection)->select(DB::raw("TPCHREQ_PCHCD,max(TTLDETAIL) TTLDETAIL, max(T_PCHREQHEAD.created_at) CREATED_AT,max(TPCHREQ_PURPOSE) TPCHREQ_PURPOSE, max(TPCHREQ_REJCTDT) TPCHREQ_REJCTDT, max(TPCHREQ_APPRVDT) TPCHREQ_APPRVDT,MPCHREQTYPE_NAME,TPCHREQ_TYPE"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TPCHREQ_PCHCD", "=", "TPCHREQDETA_PCHCD");
                })
                ->leftJoin("M_PCHREQTYPE", "TPCHREQ_TYPE", "=", "MPCHREQTYPE_ID")
                ->leftJoin('T_PCHORDHEAD', 'TPCHREQ_PCHCD', '=', 'TPCHORD_REQCD')
                ->whereNull('TPCHORD_REQCD')
                ->groupBy('TPCHREQ_PCHCD', 'MPCHREQTYPE_NAME', 'TPCHREQ_TYPE')->get();
        }
        return [
            'data' => $dataPurchaseRequestTobeUpproved, 'dataApproved' => $dataPurchaseRequestApproved
        ];
    }

    function approve(Request $request)
    {
        if (in_array(Auth::user()->role, ['accounting', 'director'])) {
            $PRCode = base64_decode($request->id);
            $RSPR = T_PCHREQHEAD::on($this->dedicatedConnection)->select('TPCHREQ_SUPCD', 'MSUP_CGCON')
                ->leftJoin('M_SUP', 'TPCHREQ_SUPCD', '=', 'MSUP_SUPCD')
                ->where('TPCHREQ_PCHCD', $PRCode)
                ->first();

            # Periksa registrasi CG aktif di CG tujuan pada Customer Master
            $RSCGActiveAsCustomer = M_CUS::on($RSPR->MSUP_CGCON)->select('MCUS_CUSCD')
                ->where('MCUS_CGCON', $this->dedicatedConnection)->first();

            if (empty($RSCGActiveAsCustomer)) {
                return response()->json(['message' => 'please register current company as their customer connection'], 403);
            }

            # registrasi Item (jika belum ada) di CG tujuan pada Item Master
            $RSPRDetail = T_PCHREQDETA::on($this->dedicatedConnection)->select('TPCHREQDETA_ITMQT', 'M_ITM.*')
                ->leftJoin('M_ITM', 'TPCHREQDETA_ITMCD', '=', 'MITM_ITMCD')
                ->where('TPCHREQDETA_PCHCD', $PRCode)
                ->whereNull('deleted_at')
                ->get();
            foreach ($RSPRDetail as $r) {
                $totalRow = M_ITM::on($RSPR->MSUP_CGCON)->where('MITM_ITMCD', $r->MITM_ITMCD)->count();
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
                    ]);
                }
            }

            $affectedRow = T_PCHREQHEAD::on($this->dedicatedConnection)->where('TPCHREQ_PCHCD', $PRCode)
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

    function reject(Request $request)
    {
        if (in_array(Auth::user()->role, ['accounting', 'director'])) {
            $affectedRow = T_PCHREQHEAD::on($this->dedicatedConnection)->where('TPCHREQ_PCHCD', base64_decode($request->id))
                ->update([
                    'TPCHREQ_REJCTBY' => Auth::user()->nick_name, 'TPCHREQ_REJCTDT' => date('Y-m-d H:i:s')
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
