<?php

namespace App\Http\Controllers;

use App\Models\ApprovalHistory;
use App\Models\C_SPK;
use App\Models\CompanyGroup;
use App\Models\M_BRANCH;
use App\Models\T_DLVORDHEAD;
use App\Models\T_PCHORDHEAD;
use App\Models\T_PCHREQHEAD;
use App\Models\T_QUOHEAD;
use App\Models\T_SLO_DRAFT_HEAD;
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
        if (isset($_COOKIE['CGID'])) {
            $this->dedicatedConnection = $_COOKIE['CGID'] === '-' ? '-' : Crypt::decryptString($_COOKIE['CGID']);
        } else {
            $this->dedicatedConnection = '-';
        }
    }
    function index()
    {
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        $Branches = M_BRANCH::select('MBRANCH_NM')->where('MBRANCH_CD', Auth::user()->branch)->first();
        return view('home', ['activeRoleDescription' => $activeRole['name'], 'BranchName' => $Branches ? $Branches->MBRANCH_NM  : '-']);
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
        $dataSalesOrderDraftTobeProcessed = [];
        $dataPurchaseOrderTobeUpproved = [];
        $dataDeliveryOrderNoDriver = [];
        $dataDeliveryOrderUndelivered = [];
        $UnApprovedSPK = [];
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        if (in_array($activeRole['code'], ['accounting', 'director', 'manager', 'general_manager'])) {
            # Query untuk data Quotation
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_QUODETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD, TQUODETA_BRANCH")
                ->groupBy("TQUODETA_QUOCD", "TQUODETA_BRANCH")
                ->whereNull('deleted_at');
            $dataTobeApproved = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT,max(TQUO_ATTN) TQUO_ATTN,TQUO_BRANCH"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD")
                        ->on("TQUO_BRANCH", "=", "TQUODETA_BRANCH");
                })
                ->join('M_CUS', function ($join) {
                    $join->on('TQUO_CUSCD', '=', 'MCUS_CUSCD')->on('TQUO_BRANCH', '=', 'MCUS_BRANCH');
                })
                ->whereNull("TQUO_APPRVDT")
                ->whereNull("TQUO_REJCTDT")
                ->groupBy('TQUO_QUOCD', 'TQUO_BRANCH')->get();

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

            # Query untuk data Purchase order
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_PCHORDDETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TPCHORDDETA_PCHCD")
                ->groupBy("TPCHORDDETA_PCHCD")
                ->whereNull('deleted_at');
            $dataPurchaseOrderTobeUpproved = T_PCHORDHEAD::on($this->dedicatedConnection)->select(DB::raw("TPCHORD_PCHCD,max(TTLDETAIL) TTLDETAIL, max(T_PCHORDHEAD.created_at) CREATED_AT"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TPCHORD_PCHCD", "=", "TPCHORDDETA_PCHCD");
                })
                ->whereNull("TPCHORD_APPRVDT")
                ->whereNull("TPCHORD_REJCTBY")
                ->groupBy('TPCHORD_PCHCD')->get();
        }

        if (in_array($activeRole['code'], ['marketing', 'marketing_adm'])) {
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_QUODETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD")
                ->where('TQUODETA_BRANCH', Auth::user()->branch)
                ->whereNull('deleted_at')
                ->groupBy("TQUODETA_QUOCD");


            $LatestApprovalStatus = ApprovalHistory::on($this->dedicatedConnection)
                ->select('code', DB::raw("MAX(id) id"), 'branch')
                ->where('form', 'QUOTATION')
                ->where('branch', Auth::user()->branch)
                ->groupBy('code', 'branch');

            $ApprovalQuotation = ApprovalHistory::on($this->dedicatedConnection)
                ->select('v1.*', 'type')
                ->joinSub($LatestApprovalStatus, 'v1', function ($join) {
                    $join->on('approval_histories.id', '=', 'v1.id');
                });

            $dataApproved = T_QUOHEAD::on($this->dedicatedConnection)->select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT, max(TQUO_REJCTDT) TQUO_REJCTDT, max(TQUO_APPRVDT) TQUO_APPRVDT,TQUO_BRANCH, type"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD");
                })
                ->join('M_CUS', function ($join) {
                    $join->on('TQUO_CUSCD', '=', 'MCUS_CUSCD')->on('TQUO_BRANCH', '=', 'MCUS_BRANCH');
                })
                ->leftJoin('T_SLOHEAD', function ($join) {
                    $join->on('TQUO_QUOCD', '=', 'TSLO_QUOCD')->on('TQUO_BRANCH', '=', 'TSLO_BRANCH');
                })
                ->leftJoinSub($ApprovalQuotation, 'v11', function ($join) {
                    $join->on('TQUO_QUOCD', '=', 'v11.code')->on('TQUO_BRANCH', '=', 'v11.branch');
                })
                ->whereNull("TSLO_QUOCD")
                ->where('TQUO_BRANCH', Auth::user()->branch)
                ->where('T_QUOHEAD.created_by', Auth::user()->nick_name)
                ->groupBy('TQUO_QUOCD', 'TQUO_BRANCH')->get();

            # Query untuk data Purchase Order Draft
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_SLO_DRAFT_DETAIL')
                ->selectRaw("COUNT(*) TTLDETAIL, TSLODRAFTDETA_SLOCD")
                ->groupBy("TSLODRAFTDETA_SLOCD")
                ->whereNull('deleted_at')
                ->where('TSLODRAFTDETA_BRANCH', Auth::user()->branch);

            $dataSalesOrderDraftTobeProcessed = T_SLO_DRAFT_HEAD::on($this->dedicatedConnection)->select(DB::raw("TSLODRAFT_SLOCD,max(TTLDETAIL) TTLDETAIL, max(T_SLO_DRAFT_HEAD.created_at) CREATED_AT,max(TSLODRAFT_POCD) TSLODRAFT_POCD"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TSLODRAFT_SLOCD", "=", "TSLODRAFTDETA_SLOCD");
                })
                ->leftJoin("T_SLOHEAD", "TSLODRAFT_SLOCD", "=", "TSLO_QUOCD")
                ->whereNull("TSLODRAFT_APPRVDT")
                ->whereNull("TSLO_QUOCD")
                ->where('TSLODRAFT_BRANCH', Auth::user()->branch)
                ->groupBy('TSLODRAFT_SLOCD')->get();
        }

        if (in_array($activeRole['code'], ['purchasing'])) {
            $RSDetail = DB::connection($this->dedicatedConnection)->table('T_PCHREQDETA')
                ->selectRaw("COUNT(*) TTLDETAIL, TPCHREQDETA_PCHCD, TPCHREQDETA_BRANCH")
                ->groupBy("TPCHREQDETA_PCHCD", "TPCHREQDETA_BRANCH")
                ->whereNull('deleted_at')
                ->where('TPCHREQDETA_BRANCH', Auth::user()->branch);
            $dataPurchaseRequestApproved = T_PCHREQHEAD::on($this->dedicatedConnection)->select(DB::raw("TPCHREQ_PCHCD,max(TTLDETAIL) TTLDETAIL, max(T_PCHREQHEAD.created_at) CREATED_AT,max(TPCHREQ_PURPOSE) TPCHREQ_PURPOSE, max(TPCHREQ_REJCTDT) TPCHREQ_REJCTDT, max(TPCHREQ_APPRVDT) TPCHREQ_APPRVDT"))
                ->joinSub($RSDetail, 'dt', function ($join) {
                    $join->on("TPCHREQ_PCHCD", "=", "TPCHREQDETA_PCHCD")->on('TPCHREQ_BRANCH', '=', 'TPCHREQDETA_BRANCH');
                })
                ->leftJoin('T_PCHORDHEAD', 'TPCHREQ_PCHCD', '=', 'TPCHORD_REQCD')
                ->whereNull('TPCHORD_REQCD')
                ->where('TPCHREQ_BRANCH', Auth::user()->branch)
                ->groupBy('TPCHREQ_PCHCD')->get();
        }

        if (in_array($activeRole['code'], ['ga'])) {
            $dataDeliveryOrderNoDriver = T_DLVORDHEAD::on($this->dedicatedConnection)->select('MCUS_CUSNM')
                ->leftJoin('M_CUS', function ($join) {
                    $join->on('TDLVORD_CUSCD', '=', 'MCUS_CUSCD')->on('TDLVORD_BRANCH', '=', 'MCUS_BRANCH');
                })
                ->whereNull('TDLVORD_DELIVERED_BY')
                ->where('TDLVORD_BRANCH', Auth::user()->branch)
                ->get();
        }

        if (in_array($activeRole['code'], ['driver'])) {
            $dataDeliveryOrderUndelivered = T_DLVORDHEAD::on($this->dedicatedConnection)->select('MCUS_CUSNM')
                ->leftJoin('M_CUS', function ($join) {
                    $join->on('TDLVORD_CUSCD', '=', 'MCUS_CUSCD')->on('TDLVORD_BRANCH', '=', 'MCUS_BRANCH');
                })
                ->where('TDLVORD_DELIVERED_BY', Auth::user()->nick_name)
                ->whereNull('TDLVORD_DELIVERED_AT')
                ->where('TDLVORD_BRANCH', Auth::user()->branch)
                ->get();
        }

        if (in_array($activeRole['code'], ['ga_manager', 'ga_spv'])) {
            $SPK = C_SPK::on($this->dedicatedConnection)->select('CSPK_PIC_AS', 'CSPK_REFF_DOC', 'CSPK_JOBDESK')
                ->whereNotNull('submitted_at');
            if ($activeRole['code'] === 'ga_manager') {
                $SPK->whereNull('CSPK_GA_MGR_APPROVED_AT');
            }
            if ($activeRole['code'] === 'ga_spv') {
                $SPK->whereNull('CSPK_GA_SPV_APPROVED_AT');
            }
            $UnApprovedSPK = $SPK->get();
            $UnApprovedSPK = json_decode(json_encode($UnApprovedSPK), true);
        }

        return [
            'data' => $dataTobeApproved, 'dataApproved' => $dataApproved,
            'dataPurchaseRequest' => $dataPurchaseRequestTobeUpproved, 'dataPurchaseRequestApproved' => $dataPurchaseRequestApproved,
            'dataSalesOrderDraft' => $dataSalesOrderDraftTobeProcessed,
            'dataPurchaseOrder' => $dataPurchaseOrderTobeUpproved,
            'dataDeliveryOrderNoDriver' => $dataDeliveryOrderNoDriver,
            'dataDeliveryOrderUndelivered' => $dataDeliveryOrderUndelivered,
            'dataUnApprovedSPK' => $UnApprovedSPK,
        ];
    }

    function TopUserNotifications()
    {
        $data = $PurchaseRequest = $PurchaseOrder = $SPKData = [];
        $activeRole = CompanyGroupController::getRoleBasedOnCompanyGroup($this->dedicatedConnection);
        if (in_array($activeRole['code'], ['accounting', 'director', 'manager', 'general_manager'])) {

            $Business = CompanyGroup::select('name', 'connection')->get();

            foreach ($Business as $r) {
                $RSDetail = DB::connection($r->connection)->table('T_QUODETA')
                    ->selectRaw("COUNT(*) TTLDETAIL, TQUODETA_QUOCD,TQUODETA_BRANCH")
                    ->groupBy("TQUODETA_QUOCD", "TQUODETA_BRANCH")
                    ->whereNull('deleted_at');
                $dataTobeApproved = T_QUOHEAD::on($r->connection)->select(DB::raw("TQUO_QUOCD,max(TTLDETAIL) TTLDETAIL,max(MCUS_CUSNM) MCUS_CUSNM, max(T_QUOHEAD.created_at) CREATED_AT,max(TQUO_SBJCT) TQUO_SBJCT,max(TQUO_ATTN) TQUO_ATTN,TQUO_BRANCH, TQUO_TYPE"))
                    ->joinSub($RSDetail, 'dt', function ($join) {
                        $join->on("TQUO_QUOCD", "=", "TQUODETA_QUOCD")
                            ->on("TQUO_BRANCH", "=", "TQUODETA_BRANCH");
                    })
                    ->join('M_CUS', 'TQUO_CUSCD', '=', 'MCUS_CUSCD')
                    ->whereNull("TQUO_APPRVDT")
                    ->whereNull("TQUO_REJCTDT")
                    ->groupBy('TQUO_QUOCD', 'TQUO_BRANCH', 'TQUO_TYPE')->get()->toArray();
                $preparedData = ['name' => $r->name, 'connection' => $r->connection, 'data' => $dataTobeApproved];
                $data[] = $preparedData;

                # Query untuk data Purchase Request dengan tipe "Auto PO" 
                $RSDetail = DB::connection($r->connection)->table('T_PCHREQDETA')
                    ->selectRaw("COUNT(*) TTLDETAIL, TPCHREQDETA_PCHCD")
                    ->groupBy("TPCHREQDETA_PCHCD")
                    ->whereNull('deleted_at');
                $dataPurchaseRequestTobeUpproved = T_PCHREQHEAD::on($r->connection)->select(DB::raw("TPCHREQ_PCHCD,max(TTLDETAIL) TTLDETAIL, max(T_PCHREQHEAD.created_at) CREATED_AT,max(TPCHREQ_PURPOSE) TPCHREQ_PURPOSE"))
                    ->joinSub($RSDetail, 'dt', function ($join) {
                        $join->on("TPCHREQ_PCHCD", "=", "TPCHREQDETA_PCHCD");
                    })
                    ->whereNull("TPCHREQ_APPRVDT")
                    ->whereNull("TPCHREQ_REJCTDT")
                    ->where("TPCHREQ_TYPE", '2')
                    ->groupBy('TPCHREQ_PCHCD')->get();
                $preparedData = ['name' => $r->name, 'connection' => $r->connection, 'data' => $dataPurchaseRequestTobeUpproved];
                $PurchaseRequest[] = $preparedData;

                # Query untuk data Purchase order
                $RSDetail = DB::connection($r->connection)->table('T_PCHORDDETA')
                    ->selectRaw("COUNT(*) TTLDETAIL, TPCHORDDETA_PCHCD")
                    ->groupBy("TPCHORDDETA_PCHCD")
                    ->whereNull('deleted_at');
                $dataPurchaseOrderTobeUpproved = T_PCHORDHEAD::on($r->connection)->select(DB::raw("TPCHORD_PCHCD,max(TTLDETAIL) TTLDETAIL, max(T_PCHORDHEAD.created_at) CREATED_AT"))
                    ->joinSub($RSDetail, 'dt', function ($join) {
                        $join->on("TPCHORD_PCHCD", "=", "TPCHORDDETA_PCHCD");
                    })
                    ->whereNull("TPCHORD_APPRVDT")
                    ->whereNull("TPCHORD_REJCTBY")
                    ->groupBy('TPCHORD_PCHCD')->get();
                $preparedData = ['name' => $r->name, 'connection' => $r->connection, 'data' => $dataPurchaseOrderTobeUpproved];
                $PurchaseOrder[] = $preparedData;

                $SPK = C_SPK::on($r->connection)->select('CSPK_PIC_AS', 'CSPK_REFF_DOC', 'CSPK_JOBDESK')
                    ->whereNotNull('submitted_at')
                    ->whereNull('CSPK_GA_MGR_APPROVED_AT')->get();
                $preparedData = ['name' => $r->name, 'connection' => $r->connection, 'data' => $SPK];
                $SPKData[] = $preparedData;
            }
        }

        return ['data' => $data, 'PurchaseRequest' => $PurchaseRequest, 'PurchaseOrder' => $PurchaseOrder, 'SPKData' => $SPKData];
    }
}
