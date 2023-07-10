<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        \Log::info('test');
        $date = date('d/m/Y h:i:s a', time());

        global $tracer, $rootSpan;
        if ($rootSpan) {
            $rootSpan->setAttribute('foo', 'bar');
            $rootSpan->setAttribute('Kishan', 'Sangani');
            $rootSpan->setAttribute('foo1', 'bar1');
            $rootSpan->updateName('OrderController\\store dated ' . $date);

            $parent = $tracer->spanBuilder("訂單開始")->startSpan();
            $scope = $parent->activate();
            try {
                $child = $tracer->spanBuilder("訂單寫入")->startSpan();
                //            $order = new Order();
                //            $order->fill($request->all());
                //            $order->save();
                $child->end();
            } finally {
                $parent->end();
                $scope->detach();
            }
        }

        // 回傳新增訂單的回應
        return response()->json(['message' => 'Order created successfully']);
    }

    public function pay($id): JsonResponse
    {
        $date = date('d/m/Y h:i:s a', time());
        global $tracer, $rootSpan;
        $rootSpan->setAttribute('foo', 'bar');
        $rootSpan->setAttribute('Kishan', 'Sangani');
        $rootSpan->setAttribute('foo1', 'bar1');
        $rootSpan->updateName('HelloController\\index dated ' . $date);

        $parent = $tracer->spanBuilder("store_order")->startSpan();
        $scope = $parent->activate();
        try {
            $child = $tracer->spanBuilder("save_order")->startSpan();
            // 在這裡處理支付訂單的邏輯
            // 根據訂單 ID 從資料庫中獲取相應的訂單
//        $order = Order::find($id);
//
//        if (!$order) {
//            return response()->json(['message' => 'Order not found'], 404);
//        }
            // 處理支付邏輯
            //


            $child->end();
        } finally {
            $parent->end();
            $scope->detach();
        }

        // 回傳支付訂單的回應
        return response()->json(['message' => 'Order paid successfully']);
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

    public function ship($id): JsonResponse
    {
        // 在這裡處理貨運
        // 根據訂單 ID 從資料庫中獲取相應的訂單
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 處理邏輯

        // 回傳取消訂單的回應
        return response()->json(['message' => 'Order canceled successfully', 'order' => $order]);
    }


}
