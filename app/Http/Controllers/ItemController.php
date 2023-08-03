<?php

namespace App\Http\Controllers;

use App\Models\M_BRANCH;
use App\Models\M_COA;
use App\Models\M_ITM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ItemController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }
    public function index()
    {
        return view('master.item', ['coas' => M_COA::on($this->dedicatedConnection)->select('*')->get(), 'branches' => M_BRANCH::on($this->dedicatedConnection)->get()]);
    }

    public function formReport()
    {

        return view('report.item');
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MITM_ITMCD' => 'required',
            'MITM_ITMCD' => [
                Rule::unique($this->dedicatedConnection . '.M_ITM', 'MITM_ITMCD')->where('MITM_BRANCH', Auth::user()->branch)
            ],
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

        M_ITM::on($this->dedicatedConnection)->create([
            'MITM_ITMCD' => $request->MITM_ITMCD,
            'MITM_ITMNM' => $request->MITM_ITMNM,
            'MITM_STKUOM' => $request->MITM_STKUOM,
            'MITM_ITMTYPE' => $request->MITM_ITMTYPE,
            'MITM_BRAND' => $request->MITM_BRAND,
            'MITM_MODEL' => $request->MITM_MODEL,
            'MITM_SPEC' => $request->MITM_SPEC,
            'MITM_ITMCAT' => $request->MITM_ITMCAT,
            'MITM_COACD' => $request->MITM_COACD,
            'MITM_BRANCH' => Auth::user()->branch
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
        $DataSet = new M_ITM();
        $DataSet->setConnection($this->dedicatedConnection);
        $RS = $DataSet->select('*')
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->where('MITM_BRANCH', Auth::user()->branch)
            ->get();
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_ITM::on($this->dedicatedConnection)
            ->where('MITM_ITMCD', base64_decode($request->id))
            ->where('MITM_BRANCH', Auth::user()->branch)
            ->update([
                'MITM_ITMNM' => $request->MITM_ITMNM,
                'MITM_STKUOM' => $request->MITM_STKUOM,
                'MITM_ITMTYPE' => $request->MITM_ITMTYPE,
                'MITM_BRAND' => $request->MITM_BRAND,
                'MITM_MODEL' => $request->MITM_MODEL,
                'MITM_SPEC' => $request->MITM_SPEC,
                'MITM_ITMCAT' => $request->MITM_ITMCAT,
                'MITM_COACD' => $request->MITM_COACD,
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }

    function report(Request $request)
    {
        $RS = M_ITM::on($this->dedicatedConnection)->select('*')->get()->toArray();
        if ($request->fileType === 'json') {
            return ['data' => $RS];
        } else {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('ITEM_MASTER');
            $sheet->freezePane('A2');
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
}
