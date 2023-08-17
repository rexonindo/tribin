<?php

namespace App\Http\Controllers;

use App\Models\T_DLVORDDETA;
use App\Models\T_SLODETA;
use App\Models\T_SLOHEAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    protected $dedicatedConnection;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
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
}
