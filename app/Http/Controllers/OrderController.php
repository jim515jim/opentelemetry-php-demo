<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\OpenTelemetry\Facades\Measure;
use Spatie\OpenTelemetry\Support\Trace;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        \Log::info('test');
        Measure::start('store_order');
        //資料寫入遙測
        Measure::start('save_order');
        // $order->save();
      // usleep(5000000);
        //資料寫入遙測結束
        Measure::stop('save_order');
        Measure::start('save_order1');
//        $order->save();
 
        dump((string)\Illuminate\Support\Facades\Http::withTrace()->get('https://httpbin.org/get'));
//https://httpbin.org/get
       // usleep(1000000);
        //資料寫入遙測結束
        Measure::stop('save_order1');
        //遙測結束
        Measure::stop('store_order');

        // 回傳新增訂單的回應
        return response()->json(['message' => 'Order created successfully']);
    }

    public function pay($id): JsonResponse
    {
        // 在這裡創建uuid
        Measure::setTraceId('b6d13ec2e184b7170c7ca9b635f3274e');
        $TraceID = Measure::TraceID();
        Measure::start('pay_order');

        // 在這裡處理支付訂單的邏輯
        // 根據訂單 ID 從資料庫中獲取相應的訂單
//        $order = Order::find($id);
//
//        if (!$order) {
//            return response()->json(['message' => 'Order not found'], 404);
//        }

        // 處理支付邏輯
        // ...
        Measure::stop('pay_order');

        // 回傳支付訂單的回應
        return response()->json(['message' => 'Order paid successfully', 'TraceID' => $TraceID]);
    }

    public function cancel($id): JsonResponse
    {
        // 在這裡處理取消訂單的邏輯
        // 根據訂單 ID 從資料庫中獲取相應的訂單
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 處理取消邏輯
        // ...

        // 回傳取消訂單的回應
        return response()->json(['message' => 'Order canceled successfully', 'order' => $order]);
    }

//    public function store(Request $request): JsonResponse
//    {
//        // 在這裡創建uuid
//        $uuid = Str::uuid()->toString();
//        //遙測開始
//        Measure::startTrace();
//        $traceID = Measure::TraceID();
//        Measure::start('store_order')->tags([
//            'uuid' => $uuid,
//        ]);
//        // 建立新的訂單並保存到資料庫
//        $order = new Order();
//        // 設定訂單資料
//        $order->uuid = $uuid;
//        $order->name = $request->input('name');
//        $order->amount = $request->input('amount');
//
//        //資料寫入遙測
//        Measure::start('save_order');
////        $order->save();
//        //資料寫入遙測結束
//        Measure::stop('save_order');
//        //遙測結束
//        Measure::stop('store_order');
//
//        // 回傳新增訂單的回應
//        return response()->json(['message' => 'Order created successfully', 'order' => $order, 'TraceID' => $traceID]);
//    }
}
