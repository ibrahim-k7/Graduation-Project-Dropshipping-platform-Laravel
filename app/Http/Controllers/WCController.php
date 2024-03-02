<?php

namespace App\Http\Controllers;

require __DIR__ . '/../../../vendor/autoload.php';

use Automattic\WooCommerce\Client;
use Illuminate\Http\Request;
class WCController extends Controller
{
    public function linkProduct(Request $request){
        $woocommerce = new Client(
            'https://m5zndrop.online/',
            'ck_5fac83320f432d1efc44e8a16f4d30eaa916f4c0',
            'cs_e60d57a56819c9170c50d90ba54234d67344381a',
            [
                'version' => 'wc/v3',
            ]
        );

        //شرط تأكد اذا كان المنتج موجود في المتجر
        if ($this->retrieveProductID($request->name)){
            abort(400, 'المنتج موجود في المتجر');
        }else{
            $data = [
                'name' => $request->name,
                'regular_price' => $request->price,
                'description' => $request->desc,
//            'images' => [
//                [
//                    'src' => $request->image
//                ]
//            ],
            ];

            print_r($woocommerce->post('products', $data));
        }
    }

    public function retrieveProductID($name){
        $woocommerce = new Client(
            'https://m5zndrop.online/',
            'ck_5fac83320f432d1efc44e8a16f4d30eaa916f4c0',
            'cs_e60d57a56819c9170c50d90ba54234d67344381a',
            [
                'version' => 'wc/v3',
            ]
        );

        //استدعاء المنتجات من المتجر
        $response  = $woocommerce->get('products');
        $products = collect($response);

        // للبحث عن المنتج بالاسم
        $product = $products->firstWhere('name', $name);

        //التاكد من وجود المنتج
        if ($product){
            //ارجاع id المنتج
            return $product->id;
        }else{
            return false;
        }
    }

    public function unlinkProduct(Request $request){
        $woocommerce = new Client(
            'https://m5zndrop.online/',
            'ck_5fac83320f432d1efc44e8a16f4d30eaa916f4c0',
            'cs_e60d57a56819c9170c50d90ba54234d67344381a',
            [
                'version' => 'wc/v3',
            ]
        );

        //اسناد id المنتج الى متغير
        $pro_id = $this->retrieveProductID($request->name);

        //شرط تأكد اذا كان المنتج موجود في المتجر
        if ($pro_id){
            $woocommerce->delete('products/'.$pro_id,['force' => true]);
        }else{
            abort(400,'المنتج غير موجود في المتجر');
        }
    }
}
