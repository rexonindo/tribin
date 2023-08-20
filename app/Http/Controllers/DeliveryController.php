<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroup;
use App\Models\M_BRANCH;
use App\Models\T_DLVORDDETA;
use App\Models\T_DLVORDHEAD;
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
            'TDLVORD_REMARK' => $request->TDLVORD_REMARK,
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

    function update(Request $request)
    {
        # ubah data header
        $affectedRow = T_DLVORDHEAD::on($this->dedicatedConnection)
            ->where('TDLVORD_DLVCD', base64_decode($request->id))
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->update([
                'TDLVORD_REMARK' => $request->TDLVORD_REMARK,
                'TDLVORD_ISSUDT' => $request->TDLVORD_ISSUDT,
                'TDLVORD_INVCD' => $request->TDLVORD_INVCD,
                'updated_by' => Auth::user()->nick_name,
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
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
        $RSHeader = T_DLVORDHEAD::on($this->dedicatedConnection)->select('TDLVORD_ISSUDT', 'MCUS_CUSNM', 'TDLVORD_REMARK', 'MCUS_TELNO', 'TDLVORD_INVCD')
            ->leftJoin('M_CUS', function ($join) {
                $join->on('TDLVORD_CUSCD', '=', 'MCUS_CUSCD')->on('TDLVORD_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->where("TDLVORD_DLVCD", $doc)
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->first();
        $DOIssuDate = date_format(date_create($RSHeader->TDLVORD_ISSUDT), 'd-M-Y');
        $Branch = M_BRANCH::select('MBRANCH_NM')->where('MBRANCH_CD', Auth::user()->branch)->first();
        $Company = CompanyGroup::select('name', 'address', 'phone')->where('connection', $this->dedicatedConnection)->first();
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
        $Capacity = NULL;
        $Model = NULL;
        $Merk = NULL;
        $Usage = NULL;
        $HargaSewa = NULL;
        foreach ($RSDetail as $r) {
            $Capacity = $r->MITM_ITMNM;
            $Model = $r->MITM_MODEL;
            $Merk = $r->MITM_BRAND;
            $Usage = $r->TSLODETA_USAGE;
            $Dibuat = User::where('nick_name', $r->created_by)->select('name')->first();
            $Attn = T_SLOHEAD::on($this->dedicatedConnection)->select('TSLO_ATTN', 'TSLO_QUOCD', 'TSLO_POCD')
                ->where('TSLO_SLOCD', $r->TDLVORDDETA_SLOCD)
                ->where('TSLO_BRANCH', Auth::user()->branch)
                ->first();
            $Usage = T_SLODETA::on($this->dedicatedConnection)->select('TSLODETA_USAGE', 'TSLODETA_PRC', 'TSLODETA_OPRPRC', 'TSLODETA_MOBDEMOB')
                ->where('TSLODETA_SLOCD', $r->TDLVORDDETA_SLOCD)
                ->where('TSLODETA_BRANCH', Auth::user()->branch)
                ->first();
            $HargaSewa = $Usage->TSLODETA_OPRPRC + $Usage->TSLODETA_OPRPRC + $Usage->TSLODETA_MOBDEMOB;
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
                $this->fpdf->Cell(12, 5, $nomor, 0, 0, 'L');
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
            $this->fpdf->Cell(20, 5, ': Invoice ' . $Subject->TQUO_SBJCT, 0, 0, 'L');

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
            $this->fpdf->Cell(20, 5, 'Bersama ini kami lakukan penagihan atas ' . $Subject->TQUO_SBJCT . ' dengan rincian sebagai berikut', 0, 0, 'L');
            $this->fpdf->SetXY(7, 60);
            $this->fpdf->Cell(50, 5, 'NO. PR', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, ': ' . $Attn->TSLO_POCD, 0, 0, 'L');
            $this->fpdf->SetXY(7, 65);
            $this->fpdf->Cell(50, 5, 'Merk', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, ': ' . $Merk, 0, 0, 'L');
            $this->fpdf->SetXY(7, 70);
            $this->fpdf->Cell(50, 5, 'Capacity', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, ': ' . $Capacity, 0, 0, 'L');
            $this->fpdf->SetXY(7, 75);
            $this->fpdf->Cell(50, 5, 'Model', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, ': ' . $Model, 0, 0, 'L');
            $this->fpdf->SetXY(7, 80);
            $this->fpdf->Cell(50, 5, 'Pemakaian', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, ': ' . $Usage->TSLODETA_USAGE . ' Jam', 0, 0, 'L');
            $this->fpdf->SetXY(7, 85);
            $this->fpdf->Cell(50, 5, 'Periode', 0, 0, 'L');
            $this->fpdf->Cell(50, 5, ': ', 0, 0, 'L');
            $this->fpdf->SetXY(7, 90);
            $this->fpdf->Cell(50, 5, 'Harga Sewa', 0, 0, 'L');
            $this->fpdf->Cell(3, 5, ':', 0, 0, 'L');
            $this->fpdf->Cell(25, 5, ' ' . number_format($HargaSewa), 0, 0, 'R');

            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->SetXY(7, 100);
            $this->fpdf->Cell(50, 5, 'Total', 0, 0, 'L');
            $this->fpdf->Cell(3, 5, ':', 0, 0, 'L');
            $this->fpdf->Cell(25, 5, ' ' . number_format($HargaSewa), 0, 0, 'R');
            $PPNAmount = $HargaSewa * 11 / 100;
            $this->fpdf->SetXY(7, 105);
            $this->fpdf->Cell(50, 5, 'PPN 11%', 0, 0, 'L');
            $this->fpdf->Cell(3, 5, ':', 0, 0, 'L');
            $this->fpdf->Cell(25, 5, ' ' . number_format($PPNAmount), 0, 0, 'R');
            $this->fpdf->SetXY(7, 110);
            $this->fpdf->Cell(50, 5, 'Total Tagihan', 0, 0, 'L');
            $this->fpdf->Cell(3, 5, ':', 0, 0, 'L');
            $this->fpdf->Cell(25, 5, ' ' . number_format($PPNAmount + $HargaSewa), 0, 0, 'R');
            $this->fpdf->SetXY(7, 120);
            $this->fpdf->Cell(0, 5, ucwords(rtrim($this->numberToSentence($PPNAmount + $HargaSewa))), 0, 0, 'C');
        }


        $this->fpdf->Output('delivery order ' . $doc . '.pdf', 'I');
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
            ['Drivers' => User::select('nick_name', 'name')
                ->where('branch', Auth::user()->branch)
                ->where('role', 'driver')
                ->get()]
        );
    }

    function emptyDriver(Request $request)
    {
        $data = T_DLVORDHEAD::on($this->dedicatedConnection)->select('MCUS_CUSNM', 'TDLVORD_DLVCD', 'TDLVORD_BRANCH', 'T_DLVORDHEAD.created_at')
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
        $affectedRow = T_DLVORDHEAD::on($this->dedicatedConnection)
            ->where('TDLVORD_DLVCD', base64_decode($request->id))
            ->where('TDLVORD_BRANCH', $request->TDLVORD_BRANCH)
            ->update([
                'TDLVORD_DELIVERED_BY' => $request->TDLVORD_DELIVERED_BY
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

    function formDeliveryConfirmation()
    {
        return view(
            'transaction.delivery_confirmation'
        );
    }

    function emptyDeliveryDateTime(Request $request)
    {
        $data = T_DLVORDHEAD::on($this->dedicatedConnection)->select('MCUS_CUSNM', 'TDLVORD_DLVCD', 'TDLVORD_BRANCH', 'T_DLVORDHEAD.created_at')
            ->leftJoin('M_CUS', function ($join) {
                $join->on('TDLVORD_CUSCD', '=', 'MCUS_CUSCD')->on('TDLVORD_BRANCH', '=', 'MCUS_BRANCH');
            })
            ->whereNull('TDLVORD_DELIVERED_AT')
            ->where('TDLVORD_DELIVERED_BY', Auth::user()->nick_name)
            ->where('TDLVORD_BRANCH', Auth::user()->branch)
            ->get();
        return ['data' => $data];
    }
}
