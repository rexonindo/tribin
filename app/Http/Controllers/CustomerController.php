<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroup;
use App\Models\M_CUS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    public function index()
    {
        return view('master.customer', ['companies' => CompanyGroup::select('*')->where('connection', '!=', $this->dedicatedConnection)->get()]);
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MCUS_CUSCD' => 'required',
            'MCUS_CUSCD' => [
                Rule::unique($this->dedicatedConnection . '.M_CUS', 'MCUS_CUSCD')->where('MCUS_BRANCH', Auth::user()->branch)
            ],
            'MCUS_CUSNM' => 'required',
            'MCUS_CURCD' => 'required',
            'MCUS_TAXREG' => 'required',
            'MCUS_ADDR1' => 'required',
            'MCUS_TELNO' => 'required',
            'MCUS_PIC_NAME' => 'required',
            'MCUS_PIC_TELNO' => 'required',
            'MCUS_TYPE' => 'required',
            'MCUS_KTP_FILE' => 'required|mimes:png,jpg,jpeg,pdf|max:2048',
            'MCUS_NPWP_FILE' => 'required|mimes:png,jpg,jpeg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }

        if ($request->MCUS_TYPE === '2') {
            $validator = Validator::make($request->all(), [
                'MCUS_NIB_FILE' => 'required|mimes:png,jpg,jpeg,pdf|max:2048',
            ]);
        }
        if ($validator->fails()) {
            return response()->json($validator->errors(), 406);
        }
        $KTPfileName = null;
        $NPWPfileName = null;
        $NIBfileName = null;
        if ($request->file('MCUS_KTP_FILE')) {
            $file = $request->file('MCUS_KTP_FILE');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $KTPfileName = $fileName;
            $location = 'attachments/customer';
            $file->move(public_path($location), $fileName);
        }
        if ($request->file('MCUS_NPWP_FILE')) {
            $file = $request->file('MCUS_NPWP_FILE');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $NPWPfileName = $fileName;
            $location = 'attachments/customer';
            $file->move(public_path($location), $fileName);
        }
        if ($request->file('MCUS_NIB_FILE')) {
            $file = $request->file('MCUS_NIB_FILE');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $NIBfileName = $fileName;
            $location = 'attachments/customer';
            $file->move(public_path($location), $fileName);
        }
        M_CUS::on($this->dedicatedConnection)->create([
            'MCUS_CUSCD' => $request->MCUS_CUSCD,
            'MCUS_CUSNM' => $request->MCUS_CUSNM,
            'MCUS_CURCD' => $request->MCUS_CURCD,
            'MCUS_TAXREG' => $request->MCUS_TAXREG,
            'MCUS_ADDR1' => $request->MCUS_ADDR1,
            'MCUS_TELNO' => $request->MCUS_TELNO,
            'MCUS_CGCON' => $request->MCUS_CGCON,
            'created_by' => Auth::user()->nick_name,
            'MCUS_BRANCH' => Auth::user()->branch,
            'MCUS_TYPE' => $request->MCUS_TYPE,
            'MCUS_GROUP' => $request->MCUS_GROUP,
            'MCUS_REFF_MKT' => $request->MCUS_REFF_MKT,
            'MCUS_PIC_NAME' => $request->MCUS_PIC_NAME,
            'MCUS_PIC_TELNO' => $request->MCUS_PIC_TELNO,
            'MCUS_EMAIL' => $request->MCUS_EMAIL,
            'MCUS_KTP_FILE' => $KTPfileName,
            'MCUS_NPWP_FILE' => $NPWPfileName,
            'MCUS_NIB_FILE' => $NIBfileName,
        ]);
        return ['msg' => 'OK'];
    }

    function search(Request $request)
    {
        $columnMap = [
            'MCUS_CUSCD',
            'MCUS_CUSNM',
            'MCUS_ADDR1',
        ];
        $RS = M_CUS::on($this->dedicatedConnection)->select('*')
            ->where($columnMap[$request->searchBy], 'like', '%' . $request->searchValue . '%')
            ->where('MCUS_BRANCH', Auth::user()->branch)
            ->get();
        return ['data' => $RS];
    }

    function update(Request $request)
    {
        $affectedRow = M_CUS::on($this->dedicatedConnection)
            ->where('MCUS_CUSCD', base64_decode($request->id))
            ->where('MCUS_BRANCH', Auth::user()->branch)
            ->update([
                'MCUS_CUSNM' => $request->MCUS_CUSNM, 'MCUS_CURCD' => $request->MCUS_CURCD,
                'MCUS_TAXREG' => $request->MCUS_TAXREG, 'MCUS_ADDR1' => $request->MCUS_ADDR1,
                'MCUS_TELNO' => $request->MCUS_TELNO, 'MCUS_CGCON' => $request->MCUS_CGCON,
                'MCUS_TYPE' => $request->MCUS_TYPE, 'MCUS_GROUP' => $request->MCUS_GROUP,
                'MCUS_REFF_MKT' => $request->MCUS_REFF_MKT, 'MCUS_PIC_NAME' => $request->MCUS_PIC_NAME,
                'MCUS_PIC_TELNO' => $request->MCUS_PIC_TELNO, 'MCUS_EMAIL' => $request->MCUS_EMAIL,
            ]);
        return ['msg' => $affectedRow ? 'OK' : 'No changes'];
    }
}
