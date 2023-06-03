<?php

use App\Http\Controllers\AccessRulesController;
use App\Http\Controllers\CoaController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

# Autentikasi
Route::get('/welcome', [LoginController::class, 'login'])->name('login');
Route::get('/', [PageController::class, 'index']);
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

# Terkait tampilan awal
Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('menu', [AccessRulesController::class, 'getAccessRolesByRoleName'])->middleware('auth');

# Terkait tampilan user registration
Route::get('user/registration', [UserController::class, 'index'])->middleware('auth');

# Terkait seting akses user
Route::get('/setting/access', [AccessRulesController::class, 'index'])->middleware('auth');

Route::get('/version', function () {
    return app()->version();
});

# Terkait Item Master
Route::get('item/form', [ItemController::class, 'index'])->middleware('auth');
Route::get('item', [ItemController::class, 'search'])->middleware('auth');
Route::post('item', [ItemController::class, 'simpan'])->middleware('auth');
Route::put('item/{id}', [ItemController::class, 'update'])->middleware('auth');


# Terkait Customer Master
Route::get('customer/form', [CustomerController::class, 'index'])->middleware('auth');
Route::get('customer', [CustomerController::class, 'search'])->middleware('auth');
Route::post('customer', [CustomerController::class, 'simpan'])->middleware('auth');
Route::put('customer/{id}', [CustomerController::class, 'update'])->middleware('auth');

# Terkait Supplier Master
Route::get('supplier/form', [SupplierController::class, 'index'])->middleware('auth');
Route::get('supplier', [SupplierController::class, 'search'])->middleware('auth');
Route::post('supplier', [SupplierController::class, 'simpan'])->middleware('auth');
Route::put('supplier/{id}', [SupplierController::class, 'update'])->middleware('auth');

# Terkait Chart of Account Master
Route::get('coa/form', [CoaController::class, 'index'])->middleware('auth');
Route::get('coa', [CoaController::class, 'search'])->middleware('auth');
Route::post('coa', [CoaController::class, 'simpan'])->middleware('auth');
Route::put('coa/{id}', [CoaController::class, 'update'])->middleware('auth');


# Terkait Quotation Transaction
Route::get('quotation/form', [QuotationController::class, 'index'])->middleware('auth');