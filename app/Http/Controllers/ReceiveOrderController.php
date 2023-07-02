<?php

namespace App\Http\Controllers;

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
        return view('transaction.receive_order');
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
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        $LastLine = DB::connection($this->dedicatedConnection)->table('T_SLOHEAD')
            ->whereMonth('created_at', '=', date('m'))
            ->whereYear('created_at', '=', date('Y'))
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
            'created_by' => Auth::user()->nick_name,
        ];
        T_SLOHEAD::on($this->dedicatedConnection)->create($quotationHeader);

        # data quotation detail item
        $validator = Validator::make($request->all(), [
            'TSLODETA_ITMCD' => 'required|array',
            'TSLODETA_USAGE' => 'required|array',
            'TSLODETA_USAGE.*' => 'required|numeric',
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
                'TSLODETA_USAGE' => $request->TSLODETA_USAGE[$i],
                'TSLODETA_PRC' => $request->TSLODETA_PRC[$i],
                'TSLODETA_OPRPRC' => $request->TSLODETA_OPRPRC[$i],
                'TSLODETA_MOBDEMOB' => $request->TSLODETA_MOBDEMOB[$i],
                'created_by' => Auth::user()->nick_name,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        if (!empty($quotationDetail)) {
            T_SLODETA::on($this->dedicatedConnection)->insert($quotationDetail);
        }

        return [
            'msg' => 'OK', 'doc' => $newDocumentCode
            , '$RSLast' => $LastLine
            , 'quotationHeader' => $quotationHeader
            , 'quotationDetail' => $quotationDetail
            , 'newPOCode' => $newPOCode
        ];
    }

    function search(Request $request)
    {
        $columnMap = [
            'TSLO_SLOCD',
            'MCUS_CUSNM',
            'TSLO_POCD',
        ];

        $RS = T_SLOHEAD::on($this->dedicatedConnection)->select(["TSLO_SLOCD", "TSLO_CUSCD", "MCUS_CUSNM", "TSLO_ISSUDT", "TSLO_QUOCD", "TSLO_POCD", "TSLO_ATTN", "TSLO_PLAN_DLVDT"])
            ->leftJoin("M_CUS", "TSLO_CUSCD", "=", "MCUS_CUSCD")
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->get();
        return ['data' => $RS];
    }

    function loadById(Request $request)
    {
        $RS = T_SLODETA::on($this->dedicatedConnection)->select(["id", "TSLODETA_ITMCD", "MITM_ITMNM", "TSLODETA_USAGE", "TSLODETA_PRC", "TSLODETA_OPRPRC", "TSLODETA_MOBDEMOB"])
            ->leftJoin("M_ITM", "TSLODETA_ITMCD", "=", "MITM_ITMCD")
            ->where('TSLODETA_SLOCD', base64_decode($request->id))
            ->whereNull('deleted_at')->get();
        return ['dataItem' => $RS];
    }

    function deleteItemById(Request $request)
    {
        $affectedRow = T_SLODETA::on($this->dedicatedConnection)->where('id', $request->id)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => Auth::user()->nick_name
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'could not be deleted', 'affectedRow' => $affectedRow];
    }

    public function update(Request $request)
    {
        # ubah data header
        $affectedRow = T_SLOHEAD::on($this->dedicatedConnection)->where('TSLO_SLOCD', base64_decode($request->id))
            ->update([
                'TSLO_CUSCD' => $request->TSLO_CUSCD, 'TSLO_ATTN' => $request->TSLO_ATTN, 'TSLO_POCD' => $request->TSLO_POCD, 'TSLO_ISSUDT' => $request->TSLO_ISSUDT, 'TSLO_PLAN_DLVDT' => $request->TSLO_PLAN_DLVDT
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
    public function formReport()
    {
        return view('report.receive_order');
    }
    function report(Request $request)
    {
        $RS = T_SLOHEAD::on($this->dedicatedConnection)->select(DB::raw("T_SLOHEAD.*,MCUS_CUSNM,TSLODETA_ITMCD,MITM_ITMNM,TSLODETA_ITMQT,TSLODETA_USAGE,TSLODETA_PRC,TSLODETA_OPRPRC,TSLODETA_MOBDEMOB"))
            ->leftJoin('T_SLODETA', 'TSLO_SLOCD', '=', 'TSLODETA_SLOCD')
            ->leftJoin('M_ITM', 'TSLODETA_ITMCD', '=', 'MITM_ITMCD')
            ->join('M_CUS', 'TSLO_CUSCD', '=', 'MCUS_CUSCD')
            ->where("TSLO_ISSUDT", ">=", $request->dateFrom)
            ->where("TSLO_ISSUDT", "<=", $request->dateTo)
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
}
