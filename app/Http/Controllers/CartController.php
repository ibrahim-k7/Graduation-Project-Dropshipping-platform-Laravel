<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\DealerProduct;
use App\Models\CartItem;
use App\Models\Cart;





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
        
        // Assuming you have a 'product' relationship in your Cart model
        if ($cart) {
            $product = $cart->product;
        
            // Loop through each product and get its name
            $productNames = $product->pluck('name')->toArray();
        
            return dd($productNames);
        } else {
            return "Cart not found.";
        }
        
        

        
        // return view('user.cart.cart', compact('cartItems'));
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
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

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
    public function update(Request $request, $id)
    {
        //
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
