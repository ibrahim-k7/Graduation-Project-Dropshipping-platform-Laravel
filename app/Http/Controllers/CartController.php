<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\DealerProduct;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderDetails;
use Psy\Readline\Hoa\Console;
use Symfony\Component\Console\Logger\ConsoleLogger;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store_id = Auth::user()->store_id;
        $cart = Cart::where('store_id', $store_id)->with('product')->first();
        $product = $cart->product;

        if ($cart) {
            $delivery = Delivery::select("*")->get();

            return view('user.cart.cart', compact('product', 'delivery'));
        } else {
            abort(404, 'لا يوجد منتجات في السلة');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $store_id = Auth::user()->store_id;
        $cart = Cart::where('store_id', $store_id)->first();
        $dealerProduct = DealerProduct::where('dealer_pro_id', $request->id)->select('*')->first();

        $existingProduct = CartItem::where('cart_id', $cart->cart_id)
            ->where('pro_id', $dealerProduct->pro_id)
            ->first();

        if ($existingProduct) {
            abort(400, 'فشلت العملية    ');
        } else {
            CartItem::create([
                'cart_id' => $cart->cart_id,
                'pro_id' => $dealerProduct->pro_id,
                'quantity' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function storeOrder(Request $request)
    {
        $store_id = Auth::user()->store_id;
        $cartItems = Cart::where('store_id', $store_id)->with('product')->select("*")->get();

        foreach ($cartItems as $cartItem) {
            foreach ($cartItem->product as $product) {
                Order::create([
                    'store_id' => $store_id,
                    'delivery_id' => '1',
                    'platform' => 'سلة',
                    'payment_status' => 'لم يتم الدفع',
                    'customer_phone' => $request->customer_phone,
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'shipping_address' => $request->shipping_address,
                    'order_status' => 'يتم توصيل الطلب',
                    'total_per_shp' => '55',
                    'total_weight' => $product->weight,
                    'total_amount' => $product->selling_price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                // $productQuantity = $product->quantity;

                // if ($productQuantity >= $request->quantity) {
                OrderDetails::create([
                    'pro_id' =>  $product->id,
                    'order_id'=> 13,
                    'quantity' =>  2,
                    'total_cost' =>   $product->selling_price * 2,
                    'sub_weight' =>  $product->weight * 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                // }
            }
        }
    }
    //

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        $store_id = Auth::user()->store_id;
        $cart = Cart::where('store_id', $store_id)->first();
        $newquantity = $request->quantity;
        $cartItem = CartItem::where(['cart_id' => $cart->cart_id])
            ->where(['pro_id' => $request->pro_id])
            ->with('product')
            ->first();
        // $newquantity = $request->quantity;
        $perPrice = $newquantity * $cartItem->product->selling_price;
        return ($perPrice);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
