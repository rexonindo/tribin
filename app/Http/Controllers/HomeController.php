<?php

namespace App\Http\Controllers;

use App\Models\T_PCHREQHEAD;
use App\Models\T_QUOHEAD;
use App\Models\T_SLOHEAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        $this->dedicatedConnection = $_COOKIE['CGID'] === '-' ? '-' : Crypt::decryptString($_COOKIE['CGID']);
    }
    function index()
    {
        return view('home');
    }

    function supportDashboard()
    {
        $data = [];

        # Quotation yang sudah dibuat
        $RSQuotationDeatail = DB::connection($this->dedicatedConnection)->table('T_QUODETA')
            ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
            ->groupBy("TQUODETA_QUOCD")
            ->whereNull('deleted_at');
        $RSQuoation = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT"))
            ->joinSub($RSQuotationDeatail, 'dt', function ($join) {
                $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
            })
            ->count();
        $data['createdQuotations'] = $RSQuoation;

        # Quotation yang sudah disetujui
        $RSQuotationDeatail = DB::connection($this->dedicatedConnection)->table('T_QUODETA')
            ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
            ->groupBy("TQUODETA_QUOCD")
            ->whereNull('deleted_at');
        $RSQuoation = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::connection($this->dedicatedConnection)->raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT"))
            ->joinSub($RSQuotationDeatail, 'dt', function ($join) {
                $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
            })
            ->whereNotNull("TQUO_APPRVDT")
            ->count();
        $data['approvedQuotations'] = $RSQuoation;

        # Waktu terakhir operasi quotation
        $data['lastCreatedQuotationDateTime'] = DB::connection($this->dedicatedConnection)->table('T_QUOHEAD')->max('created_at');

        # Sales yang sudah dibuat
        $RSSalesDeatail = DB::connection($this->dedicatedConnection)->table('T_SLODETA')
            ->selectRaw("COUNT(*) TTLDETAIL, TSLODETA_SLOCD")
            ->groupBy("TSLODETA_SLOCD")
            ->whereNull('deleted_at');
        $RSSales = T_SLOHEAD::on($this->dedicatedConnection)->select(DB::connection($this->dedicatedConnection)->raw("TSLO_SLOCD,max(TTLDETAIL) TTLDETAIL, max(T_SLOHEAD.created_at) CREATED_AT"))
            ->joinSub($RSSalesDeatail, 'dt', function ($join) {
                $join->on("TSLO_SLOCD", "=", "TSLODETA_SLOCD");
            })
            ->count();
        $data['createdSales'] = $RSSales;

        # Waktu terakhir operasi sales order
        $data['lastCreatedSODateTime'] = DB::connection($this->dedicatedConnection)->table('T_SLOHEAD')->max('created_at');
        return ['data' => $data];
    }

    function notifications()
    {
        $dataTobeApproved = $dataPurchaseRequestTobeUpproved = [];
        $dataApproved = $dataPurchaseRequestApproved = [];
        if (in_array(Auth::user()->role, ['accounting', 'director'])) {
            # Query untuk data Quotation
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_QUODETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
                ->groupBy("TQUODETA_QUOCD")
                ->whereNull('deleted_at');
            $dataTobeApproved = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT,max(TQUO_ATTN) TQUO_ATTN"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
                })
                ->join('M_CUS', 'TQUO_CUSCD', '=', 'MCUS_CUSCD')
                ->whereNull("TQUO_APPRVDT")
                ->whereNull("TQUO_REJCTDT")
                ->groupBy('TQUO_QUOCD')->get();

            # Query untuk data Purchase Request dengan tipe "Auto PO" 
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
        if (in_array(Auth::user()->role, ['marketing', 'marketing_adm'])) {
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_QUODETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
                ->groupBy("TQUODETA_QUOCD")
                ->whereNull('deleted_at');
            $dataApproved = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT, max(TQUO_REJCTDT) TQUO_REJCTDT, max(TQUO_APPRVDT) TQUO_APPRVDT"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
                })
                ->join('M_CUS', 'TQUO_CUSCD', '=', 'MCUS_CUSCD')
                ->leftJoin('T_SLOHEAD', 'TQUO_QUOCD', '=', 'TSLO_QUOCD')
                ->whereNull("TSLO_QUOCD")
                ->groupBy('TQUO_QUOCD')->get();
        }

        if (in_array(Auth::user()->role, ['purchasing'])) {
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_PCHREQDETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TPCHREQDETA_PCHCD")
                ->groupBy("TPCHREQDETA_PCHCD")
                ->whereNull('deleted_at');
            $dataPurchaseRequestApproved = T_PCHREQHEAD::on($this->dedicatedConnection)->select(DB::raw("TPCHREQ_PCHCD,max(TTLDETAIL) TTLDETAIL, max(T_PCHREQHEAD.created_at) CREATED_AT,max(TPCHREQ_PURPOSE) TPCHREQ_PURPOSE, max(TPCHREQ_REJCTDT) TPCHREQ_REJCTDT, max(TPCHREQ_APPRVDT) TPCHREQ_APPRVDT"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TPCHREQ_PCHCD", "=", "TPCHREQDETA_PCHCD");
                })
                ->leftJoin('T_PCHORDHEAD', 'TPCHREQ_PCHCD', '=', 'TPCHORD_REQCD')
                ->whereNull('TPCHORD_REQCD')
                ->groupBy('TPCHREQ_PCHCD')->get();
        }

        return [
            'data' => $dataTobeApproved, 'dataApproved' => $dataApproved,
            'dataPurchaseRequest' => $dataPurchaseRequestTobeUpproved, 'dataPurchaseRequestApproved' => $dataPurchaseRequestApproved
        ];
    }
}
