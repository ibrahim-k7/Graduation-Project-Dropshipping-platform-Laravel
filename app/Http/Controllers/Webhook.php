<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;

class Webhook extends Controller
{
    //دالة تقوم بإستدعاء الطلبات من متجر المستخدم
    public function orderCreated(Request $request)
    {
        // استخراج بيانات الطلب من الطلب
        $orderData = $request->all();

        // معالجة بيانات الطلب وإدراجها في قاعدة البيانات
        $this->processOrderData($orderData);

        // الرد بحالة النجاح
        return response()->json(['message' => 'Order data received and processed successfully'], 200);
//        Log::info('Webhook Request Received:', $request->all());
    }

    //دالة تقوم بإدخال الطلب الى قاعدة البيانات
    private function processOrderData($orderData)
    {
        // ادخال البيانات الى جدول الطلبات
        $order = Order::create([
            'store_id' => 18,
            'delivery_id' => 3,
            'platform' => 'moahmmed wadei',
            'payment_status' => 'لم يتم الدفع',
            'customer_phone' => $orderData['billing']['phone'],
            'customer_name' => $orderData['billing']['first_name'] . ' ' . $orderData['billing']['last_name'],
            'customer_email' => $orderData['billing']['email'],
            'shipping_address' => $orderData['shipping']['address_1'] . ' ' . $orderData['shipping']['address_2'] . ' ' . $orderData['shipping']['city'],
            'order_status' => 'قيد التنفيذ',
            'total_per_shp' => $orderData['shipping_total'],
            'total_amount' => $orderData['total'],
            'created_at' => now(),
        ]);

        //ادخال البيانات الى جدول تفاصيل الطلبات
        $lineItems = $orderData['line_items'];
        foreach ($lineItems as $item){
            $product = Product::where('name',$item['name'])->first();

            OrderDetails::create([
                'order_id' => $order->order_id,
                'pro_id' => $product->id ,
                'quantity' =>  $item['quantity'],
                'total_cost' =>  $item['total'],
                'sub_weight' =>  '0',
                'created_at' => now(),
            ]);

            //تحديث كمية المنتج في المخزن
            Product::where('id' , $product->id)->update(['quantity' =>  $product->quantity - $item['quantity']]);
        }

    }
}
