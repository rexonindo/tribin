<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    function index()
    {
        if (Auth::check()) {
            return redirect('home');
        } else {
            return view('welcome');
        }
    }
}
