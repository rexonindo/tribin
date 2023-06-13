<?php

namespace App\Http\Controllers;

use App\Models\M_COA;
use App\Models\M_ITM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ItemController extends Controller
{
    public function index()
    {
        return view('master.item', ['coas' => M_COA::select('*')->get()]);
    }

    public function formReport()
    {

        return view('report.item');
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MITM_ITMCD' => 'required|unique:App\Models\M_ITM',
            'MITM_ITMNM' => 'required',
            'MITM_STKUOM' => 'required',
            'MITM_ITMTYPE' => 'required',
            'MITM_BRAND' => 'required',
            'MITM_SPEC' => 'required',
            'MITM_ITMCAT' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        M_ITM::create([
            'MITM_ITMCD' => $request->MITM_ITMCD,
            'MITM_ITMNM' => $request->MITM_ITMNM,
            'MITM_STKUOM' => $request->MITM_STKUOM,
            'MITM_ITMTYPE' => $request->MITM_ITMTYPE,
            'MITM_BRAND' => $request->MITM_BRAND,
            'MITM_MODEL' => $request->MITM_MODEL,
            'MITM_SPEC' => $request->MITM_SPEC,
            'MITM_ITMCAT' => $request->MITM_ITMCAT,
            'MITM_COACD' => $request->MITM_COACD,
        ]);
        return ['msg' => 'OK'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'MITM_ITMCD',
            'MITM_ITMNM',
            'MITM_SPEC',
        ];
        $RS = M_ITM::select('*')->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')->get();
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_ITM::where('MITM_ITMCD', base64_decode($request->id))
            ->update([
                'MITM_ITMNM' => $request->MITM_ITMNM, 'MITM_STKUOM' => $request->MITM_STKUOM, 'MITM_ITMTYPE' => $request->MITM_ITMTYPE, 'MITM_BRAND' => $request->MITM_BRAND, 'MITM_MODEL' => $request->MITM_MODEL, 'MITM_SPEC' => $request->MITM_SPEC, 'MITM_ITMCAT' => $request->MITM_ITMCAT, 'MITM_COACD' => $request->MITM_COACD,
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    function report()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('ITEM_MASTER');
        $sheet->freezePane('A2');
        $RS = M_ITM::select('*')->get()->toArray();
        $sheet->fromArray(array_keys($RS[0]), null, 'A1');
        $sheet->fromArray($RS, null, 'A2');
        $stringjudul = "Item Master Report " . date('Y-m-d H:i:s');
        foreach (range('A', 'Z') as $r) {
            $sheet->getColumnDimension($r)->setAutoSize(true);
        }
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = $stringjudul;
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
