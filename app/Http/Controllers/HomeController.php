<?php

namespace App\Http\Controllers;

use App\Models\T_QUOHEAD;
use App\Models\T_SLOHEAD;
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

        # Quotation yang sudah dibuat
        $RSQuotationDeatail = DB::table('T_QUODETA')
            ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
            ->groupBy("TQUODETA_QUOCD")
            ->whereNull('deleted_at');
        $RSQuoation = T_QUOHEAD::select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT"))
            ->joinSub($RSQuotationDeatail, 'dt', function ($join) {
                $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
            })            
            ->count();
        $data['createdQuotations'] = $RSQuoation;

        # Quotation yang sudah disetujui
        $RSQuotationDeatail = DB::table('T_QUODETA')
            ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
            ->groupBy("TQUODETA_QUOCD")
            ->whereNull('deleted_at');
        $RSQuoation = T_QUOHEAD::select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT"))
            ->joinSub($RSQuotationDeatail, 'dt', function ($join) {
                $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
            })            
            ->whereNotNull("TQUO_APPRVDT")
            ->count();
        $data['approvedQuotations'] = $RSQuoation;

        # Waktu terakhir operasi quotation
        $data['lastCreatedQuotationDateTime'] = DB::table('T_QUOHEAD')->max('created_at');

        # Sales yang sudah dibuat
        $RSSalesDeatail = DB::table('T_SLODETA')
            ->selectRaw("COUNT(*) TTLDETAIL, TSLODETA_SLOCD")
            ->groupBy("TSLODETA_SLOCD")
            ->whereNull('deleted_at');
        $RSSales = T_SLOHEAD::select(DB::raw("TSLO_SLOCD,max(TTLDETAIL) TTLDETAIL, max(T_SLOHEAD.created_at) CREATED_AT"))
            ->joinSub($RSSalesDeatail, 'dt', function ($join) {
                $join->on("TSLO_SLOCD", "=", "TSLODETA_SLOCD");
            })            
            ->count();
        $data['createdSales'] = $RSSales;

        # Waktu terakhir operasi sales order
        $data['lastCreatedSODateTime'] = DB::table('T_SLOHEAD')->max('created_at');
        return ['data' => $data];
    }
}
