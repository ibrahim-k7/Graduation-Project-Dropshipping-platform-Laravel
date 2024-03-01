<?php

namespace App\Http\Controllers;

require __DIR__ . '/../../../vendor/autoload.php';

use Automattic\WooCommerce\Client;
use Illuminate\Http\Request;
class WCController extends Controller
{
    public function createProduct(){
        $woocommerce = new Client(
            'https://m5zndrop.online/',
            'ck_5fac83320f432d1efc44e8a16f4d30eaa916f4c0',
            'cs_e60d57a56819c9170c50d90ba54234d67344381a',
            [
                'version' => 'wc/v3',
            ]
        );

        $data = [
            'name' => 'Premium Quality',
            'type' => 'simple',
            'regular_price' => '21.99',
            'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
            'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
            'categories' => [
                [
                    'id' => 9
                ],
                [
                    'id' => 14
                ]
            ],
            'images' => [
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
                ],
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_back.jpg'
                ]
            ]
        ];

//        // Convert data array to JSON
//        $jsonData = json_encode($data);
//
//        // Set cURL options for WooCommerce request
//        $options = [
//            CURLOPT_URL => 'https://m5zndrop.online/wp-json/wc/v3/products',
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_CUSTOMREQUEST => 'POST',
//            CURLOPT_POSTFIELDS => $jsonData,
//            CURLOPT_HTTPHEADER => [
//                'Content-Type: application/json',
//                'Content-Length: ' . strlen($jsonData)
//            ]
//        ];
//
//        // Initialize cURL session
//        $curl = curl_init();
//        // Set cURL options
//        curl_setopt_array($curl, $options);
//        // Execute cURL request
//        $response = curl_exec($curl);
//        // Close cURL session
//        curl_close($curl);
//
//
////        // Output response
////        print_r($response);

        print_r($woocommerce->post('products', $data));


    }

}
