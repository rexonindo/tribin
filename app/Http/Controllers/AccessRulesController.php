<?php

namespace App\Http\Controllers;

use App\Models\CompanyGroupAccess;
use App\Models\Role;
use App\Models\Menu;
use App\Models\MenuRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AccessRulesController extends Controller
{
    protected $dedicatedConnection;

    public function __construct()
    {
        $this->dedicatedConnection = Crypt::decryptString($_COOKIE['CGID']);
    }

    public function index()
    {
        $RSRoles = Auth::user()->role === 'root' ? Role::select('*')->get() : Role::select('*')->where('name', '!=', 'root')->get();
        return view('access_rules', ['RSRoles' => $RSRoles]);
    }

    private function ishasChild(&$pmenu, $pidmenu)
    {
        $rsinside = [];
        foreach ($pmenu as &$n) {
            if ($n['parent_code'] == $pidmenu) {
                if ($n['USED'] == '0') {
                    $obj2 = [
                        'id' => $n['code'],
                        'text' => $n['name'],
                        'appUrl' => $n['url'],
                        'faCssClass' => $n['icon'],
                        'checked' => false,
                    ];
                    $n['USED'] = '1';
                    $rschild2 = $this->ishasChild($pmenu, $n['code']);
                    if (!empty($rschild2)) {
                        $obj2['children'] = $rschild2;
                    }
                    $rsinside[] = $obj2;
                }
            }
        }
        unset($n);
        return $rsinside;
    }

    public function getMenu()
    {
        return ['data' => Menu::select('*')->get()];
    }

    public function getMenuForTreeSetting()
    {
        $rs = Menu::select(['*', DB::raw("'0' USED")])->get()->toArray();
        $rsfix = [];
        foreach ($rs as &$r) {
            if ($r['USED'] == '0') {
                $obj = [
                    'id' => $r['code'],
                    'text' => $r['name'],
                    'appUrl' => $r['url'],
                    'faCssClass' => $r['icon'],
                    'checked' => false,
                ];
                $rschild = $this->ishasChild($rs, $r['code']);
                if (count($rschild) > 0) {
                    $obj['children'] = $rschild;
                }
                $rsfix[] = $obj;
                $r['USED'] = '1';
            }
        }
        unset($r);
        return $rsfix;
    }

    public function getAllAccessRoles()
    {
        return MenuRoles::select('*')->get();
    }

    function getAccessRolesByRoleName()
    {
        $rsCGRole = CompanyGroupAccess::select('role_name')
            ->where('nick_name', Auth::user()->nick_name)
            ->where('connection', $this->dedicatedConnection)
            ->whereNull('deleted_at')->first();
        $rs = MenuRoles::select(['code', 'parent_code', 'name', 'url', 'icon', DB::raw("'0' USED")])
            ->join('menus', 'menu_code', '=', 'code')
            ->where('role_name', $rsCGRole->role_name)
            ->orderBy('code', 'asc')
            ->get()->toArray();
        $rsfix = [];
        foreach ($rs as &$r) {
            if ($r['USED'] == '0') {
                $obj = [
                    'id' => $r['code'],
                    'text' => $r['name'],
                    'appUrl' => $r['url'],
                    'faCssClass' => $r['icon'],
                    'checked' => false,
                ];
                $rschild = $this->ishasChild($rs, $r['code']);
                if (count($rschild) > 0) {
                    $obj['children'] = $rschild;
                }
                $rsfix[] = $obj;
                $r['USED'] = '1';
            }
        }
        unset($r);
        return $rsfix;
    }

    function setAccess(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $grid = $request->input('groupID');
        $mnid = $request->input('menuID');
        $usrlg = Auth::user()->name ? Auth::user()->nick_name : 'ada';

        $RSTobeSave = [];
        for ($i = 0; $i < count($mnid); $i++) {
            $RSTobeSave[] = [
                'role_name' => $grid,
                'menu_code' => $mnid[$i],
                'created_by' => $usrlg,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        MenuRoles::where("role_name", $grid)->delete();
        MenuRoles::insert($RSTobeSave);
        return $RSTobeSave;
    }
}
