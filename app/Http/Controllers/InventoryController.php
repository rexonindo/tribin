<?php

namespace App\Http\Controllers;

use App\Models\C_ITRN;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class InventoryController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    function index()
    {
        return view('report.inventory_stock_status');
    }

    function queryStockStatus($param)
    {
        $columnMap = [
            'MITM_ITMCD',
            'MITM_ITMNM',
        ];
        $OpeningBalance = C_ITRN::on($this->dedicatedConnection)
            ->where('CITRN_ISSUDT', '<', $param['date'])
            ->where('CITRN_LOCCD', $param['location'])
            ->where('CITRN_BRANCH', Auth::user()->branch)
            ->select('CITRN_ITMCD', DB::raw("SUM(CITRN_ITMQT) OPENINGQT"))
            ->groupBy('CITRN_ITMCD');

        $InOut = C_ITRN::on($this->dedicatedConnection)
            ->where('CITRN_ISSUDT',  $param['date'])
            ->where('CITRN_LOCCD', $param['location'])
            ->where('CITRN_BRANCH', Auth::user()->branch)
            ->select(
                'CITRN_ITMCD',
                DB::raw("SUM(CASE WHEN CITRN_ITMQT > 0 THEN CITRN_ITMQT END) INQT"),
                DB::raw("SUM(CASE WHEN CITRN_ITMQT < 0 THEN CITRN_ITMQT END) OUTQT"),
            )
            ->groupBy('CITRN_ITMCD');

        $data = C_ITRN::on($this->dedicatedConnection)
            ->leftJoin('M_ITM', function ($join) {
                $join->on('CITRN_ITMCD', '=', 'MITM_ITMCD')
                    ->on('CITRN_BRANCH', '=', 'MITM_BRANCH');
            })
            ->leftJoinSub($OpeningBalance, 'V1', function ($join) {
                $join->on('C_ITRN.CITRN_ITMCD', '=', 'V1.CITRN_ITMCD');
            })
            ->leftJoinSub($InOut, 'V2', function ($join) {
                $join->on('C_ITRN.CITRN_ITMCD', '=', 'V2.CITRN_ITMCD');
            })
            ->where('CITRN_LOCCD', $param['location'])
            ->where($columnMap[$param['searchBy']], 'like', '%' . $param['searchValue'] . '%')
            ->where('CITRN_ISSUDT', '<=', $param['date'])
            ->where('CITRN_BRANCH', Auth::user()->branch)
            ->select(
                'MITM_ITMCD',
                'MITM_ITMNM',
                DB::raw("IFNULL(OPENINGQT,0) AS OPENINGQT"),
                DB::raw("IFNULL(INQT,0) AS INQT"),
                DB::raw("IFNULL(OUTQT,0) AS OUTQT"),
                DB::raw("SUM(CITRN_ITMQT) AS STOCKQT"),
                'MITM_STKUOM'
            )
            ->groupBy('MITM_ITMCD', 'MITM_ITMNM', 'OPENINGQT', 'INQT', 'OUTQT', 'MITM_STKUOM')
            ->get();
        return $data;
    }

    function stockStatus(Request $request)
    {
        return ['data' => $this->queryStockStatus([
            'date' => $request->date,
            'location' => $request->location,
            'searchBy' => $request->searchBy,
            'searchValue' => $request->searchValue,
        ])];
    }

    function report(Request $request)
    {
        $data = $this->queryStockStatus([
            'date' => $request->date,
            'location' => $request->location,
            'searchBy' => $request->searchBy,
            'searchValue' => $request->searchValue,
        ]);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('STOCK_STATUS');
        $sheet->setCellValue([1, 2], 'Item Code');
        $sheet->setCellValue([2, 2], 'Item Name');
        $sheet->setCellValue([3, 2], 'Opening');
        $sheet->setCellValue([4, 2], 'IN');
        $sheet->setCellValue([5, 2], 'OUT');
        $sheet->setCellValue([6, 2], 'Balance');
        $sheet->setCellValue([7, 2], 'UM');

        $y = 3;
        foreach ($data as $r) {
            $sheet->setCellValue([1, $y], $r->MITM_ITMCD);
            $sheet->setCellValue([2, $y], $r->MITM_ITMNM);
            $sheet->setCellValue([3, $y], $r->OPENINGQT);
            $sheet->setCellValue([4, $y], $r->INQT);
            $sheet->setCellValue([5, $y], $r->OUTQT);
            $sheet->setCellValue([6, $y], $r->STOCKQT);
            $sheet->setCellValue([7, $y], $r->MITM_STKUOM);
            $y++;
        }

        $stringjudul = "Stock Status Report " . date('Y-m-d H:i:s');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = $stringjudul;
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
