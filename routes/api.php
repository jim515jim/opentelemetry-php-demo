<?php

use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 訂單管理
// 新增訂單
Route::post('/order', [OrderController::class, 'store']);
// 支付訂單
// post 物流管理->新增物流編號
Route::post('/order/{id}/pay', [OrderController::class, 'pay']);
// 取消訂單
// post 物流管理->取消物流
Route::post('/order/{id}/cancel', [OrderController::class, 'cancel']);

// 物流管理
// 新增物流編號
Route::post('/order/{id}/ship', [OrderController::class, 'ship']);
// 取消物流
Route::post('/order/{id}/cancel_shipment', [OrderController::class, 'cancelShipment']);
