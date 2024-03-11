<?php

namespace App\Http\Controllers;

require __DIR__ . '/../../../vendor/autoload.php';

use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Automattic\WooCommerce\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WCController extends Controller
{
    private $woocommerce;

    //دالة تقوم بربط المنصة بمتجر المستخدم
    public function __construct()
    {
        $this->woocommerce = new Client(
            'https://m5zndrop.online/',
            'ck_5fac83320f432d1efc44e8a16f4d30eaa916f4c0',
            'cs_e60d57a56819c9170c50d90ba54234d67344381a',
            [
                'version' => 'wc/v3',
            ]
        );
    }

    public function createWebhook(){
        $data = [
            'name' => 'Order created',
            'topic' => 'order.created',
            'delivery_url' => 'https://4bda-109-200-183-238.ngrok-free.app/api/webhook/woocommerce/order-created'
        ];
        $this->woocommerce->post('webhooks', $data);
    }

    //دالة تقوم بتضمين الموصل في ال woocommerce
    public function includeShippingMethod($name, $shipping_fees)
    {
        $data = [
            'method_id' => 'free_shipping',
            'settings' => [
                'title' => $name,
                'cost' => $shipping_fees,
            ]
        ];

        $this->woocommerce->post('shipping/zones/1/methods', $data);
    }

    //دالة تقوم باستدعاء جميع الموصلين لتضمينهم في woocommerce
    public function getDelivery()
    {
        $deliveries = Delivery::all();

        foreach ($deliveries as $delivery) {
            $this->includeShippingMethod($delivery->name, $delivery->shipping_fees);
        }
    }

    //دالة لربط المنتج مع woocommerce
    public function linkProduct(Request $request)
    {
        if ($this->retrieveProductID($request->name)) {
            abort(400, 'المنتج موجود في المتجر');
        } else {
            $data = [
                'name' => $request->name,
                'regular_price' => $request->price,
                'description' => $request->desc,
                'images' => [
                    [
                        'src' => $request->image
                    ]
                ],
            ];

            $this->woocommerce->post('products', $data);
        }
    }

    private function retrieveProductID($name)
    {
        //استدعاء المنتجات من المتجر
        $response = $this->woocommerce->get('products');
        $products = collect($response);

        // للبحث عن المنتج بالاسم
        $product = $products->firstWhere('name', $name);

        //التاكد من وجود المنتج
        return $product ? $product->id : false;
    }

    //دالة لالغاء ربط المنتج مع woocommerce
    public function unlinkProduct(Request $request)
    {
        //اسناد id المنتج الى متغير
        $pro_id = $this->retrieveProductID($request->name);

        //شرط تأكد اذا كان المنتج موجود في المتجر
        if ($pro_id) {
            $this->woocommerce->delete('products/'.$pro_id,['force' => true]);
        } else {
            abort(400, 'المنتج غير موجود في المتجر');
        }
    }

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
