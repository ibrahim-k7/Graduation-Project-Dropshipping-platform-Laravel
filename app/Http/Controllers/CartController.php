<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // Initialize total weight and total amount
        $totalWeight = 0;
        $totalAmount = 0;

        // Create the order
        $order = Order::create([
            'store_id' => $store_id,
            'delivery_id' => '1',
            'platform' => 'سلة',
            'payment_status' => 'لم يتم الدفع',
            'customer_phone' => $request->customer_phone,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'shipping_address' => $request->shipping_address,
            'order_status' => 'يتم توصيل الطلب',
            'total_per_shp' => '55', // You may need to calculate this based on your logic
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Iterate through cart items and products
        foreach ($cartItems as $cartItem) {
            foreach ($cartItem->product as $product) {
                // Get the quantity from the pivot table
                $quantity = $product->pivot->quantity;
        
                // Calculate total weight and total amount for each product
                $productWeight = $product->weight * $quantity;
                $productAmount = $product->selling_price * $quantity;
        
                $totalWeight += $productWeight;
                $totalAmount += $productAmount;
        
                // Attach the product to the order
                $orderDetail = OrderDetails::create([
                    'order_id' => $order->order_id, // Use the order_id from the created order
                    'pro_id' => $product->id,
                    'quantity' => $quantity,
                    'total_cost' => $productAmount,
                    'sub_weight' => $productWeight,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        

        // Update the total weight and total amount in the order table
        $order->update([
            'total_weight' => $totalWeight,
            'total_amount' => $totalAmount,
        ]);

        // Clear the cart or perform any other necessary actions

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
        $newQuantity = $request->quantity;
        $cartItem = CartItem::where(['cart_id' => $cart->cart_id, 'pro_id' => $request->pro_id])->first();

        $cartItem->update(['quantity' => $newQuantity]);

        // Calculate the new subtotal amount for the product
        $newSubtotal = $newQuantity * $cartItem->product->selling_price;
        return ($newSubtotal);


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
