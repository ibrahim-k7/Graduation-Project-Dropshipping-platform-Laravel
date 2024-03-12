<?php

namespace App\Http\Controllers;

require __DIR__ . '/../../../vendor/autoload.php';

use App\Models\API;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Automattic\WooCommerce\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WCController extends Controller
{
    private $woocommerce;
    private $store_id;
    //دالة تقوم بربط المنصة بمتجر المستخدم
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->store_id = Auth::user()->store_id;
            $api = API::where('store_id', $this->store_id)->first();
            $this->woocommerce = new Client(
                $api->domain,
                $api->key,
                $api->secret,
                [
                    'version' => 'wc/v3',
                ]
            );
            return $next($request);
        });
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
//                'images' => [
//                    [
//                        'src' => $request->image
//                    ]
//                ],
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

}
