<?php

namespace App\Http\Controllers;

use App\Models\T_QUOHEAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    function index()
    {
        return view('home');
    }

    function supportDashboard()
    {
        $data = [];
        $RSQuotationDeatail = DB::table('T_QUODETA')
            ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
            ->groupBy("TQUODETA_QUOCD")
            ->whereNull('deleted_at');
        $RSQuoation = T_QUOHEAD::select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT"))
            ->joinSub($RSQuotationDeatail, 'dt', function ($join) {
                $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
            })
            ->join('M_CUS', 'TQUO_CUSCD', '=', 'MCUS_CUSCD')
            ->count();
        $data['createdQuotations'] = $RSQuoation;

        $RSQuotationDeatail = DB::table('T_QUODETA')
            ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
            ->groupBy("TQUODETA_QUOCD")
            ->whereNull('deleted_at');
        $RSQuoation = T_QUOHEAD::select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT"))
            ->joinSub($RSQuotationDeatail, 'dt', function ($join) {
                $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
            })
            ->join('M_CUS', 'TQUO_CUSCD', '=', 'MCUS_CUSCD')
            ->whereNotNull("TQUO_APPRVDT")
            ->count();
        $data['approvedQuotations'] = $RSQuoation;
        $data['lastCreatedQuotationDateTime'] = DB::table('T_QUOHEAD')->max('created_at');
        return ['data' => $data];
    }
}
