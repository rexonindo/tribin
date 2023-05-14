<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $RSRoles = Role::select('*')->get();
        return view('user_registration', ['RSRoles' => $RSRoles]);
    }
}
