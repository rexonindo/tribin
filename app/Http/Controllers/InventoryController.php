<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    function index()
    {
        return view('report.inventory_stock_status');
    }
}
