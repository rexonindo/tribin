<?php

use App\Http\Controllers\AccessRulesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



# Terkait API User Login
Route::put('/user/{id}', function (Request $request, $id) {
    return $id;
});

Route::get('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return ['message' => 'ok logout'];
})->middleware('auth:sanctum');


# Terkait API Menu
Route::get('/menu', [AccessRulesController::class, 'getMenu'])->middleware('auth:sanctum');
Route::get('/setting/tree', [AccessRulesController::class, 'getMenuForTreeSetting']);
Route::get('/setting/tree/roles', [AccessRulesController::class, 'getAllAccessRoles']);
Route::post('/setting/tree/roles', [AccessRulesController::class, 'setAccess'])->middleware('auth:sanctum');
