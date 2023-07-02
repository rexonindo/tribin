<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function formReport()
    {

        return view('report.maintenance_schedule');
    }
}
