<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::get('/',[LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

# Terkait tampilan awal
Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');

# Terkait tampilan user registration
Route::get('user/registration', [UserController::class, 'index'])->middleware('auth');

Route::get('/version', function () {
    return app()->version();
});
