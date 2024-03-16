<?php

namespace App\Http\Controllers;

use App\Models\API;
use App\Models\DealerProduct;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Store;
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

    //دالة تقوم بإستخراج store_id عن طريق ال domain من معلومات الطلب
    private function getStoreId($meta_data){
        $session_entry = null;

        //استخراج ال domain من معلومات الطلب
        foreach ($meta_data as $meta){
            if($meta['key'] === '_wc_order_attribution_session_entry'){
                $session_entry = $meta['value'];
                break;
            }
        }

        //استدعاء store_id من جدول ال api
        $api = API::where('domain',$session_entry)->first();
        return $api->store_id;
    }

    //دالة تقوم بإرجاع اسم المتجر
    private function getStoreName($store_id){
        $store = Store::where('store_id',$store_id)->first();
        return $store->store_name;
    }

    //دالة تقوم بإرجاع delivery_id من معلومات الطلب
    private function getDeliveryId ($shipping_lines){
        $delivery_name = null;

        //استخراخ اسم الموصل من shipping_lines
        foreach ($shipping_lines as $shipping_line){
            $delivery_name = $shipping_line['method_title'];
        }

        $delivery= Delivery::where('name',$delivery_name)->first();
        return $delivery->delivery_id;
    }
    //دالة تقوم بإدخال الطلب الى قاعدة البيانات
    private function processOrderData($orderData)
    {
        $store_id = $this->getStoreId($orderData['meta_data']);
        //$store_name = $this->getStoreName($store_id);
        $delivery_id = $this->getDeliveryId($orderData['shipping_lines']);

        // ادخال البيانات الى جدول الطلبات
        $order = Order::create([
            'store_id' => $store_id,
            'delivery_id' => $delivery_id,
            'platform' => 'Woocommerce',
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
            $product = DealerProduct::where('dealer_product_name',$item['name'])->first();

            OrderDetails::create([
                'order_id' => $order->order_id,
                'pro_id' => $product->pro_id ,
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
