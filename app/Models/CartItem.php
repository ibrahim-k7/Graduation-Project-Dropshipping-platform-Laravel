<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    //الجدول المربوط به
    protected $table = "cart_items";
    //العناصر
    protected $fillable = [
        'cart_item_id','cart_id','pro_id','quantity','created_at','updated_at'
    ];

   
    //Relations Functhion
    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'pro_id', 'id');
    // }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'cart_id');
    }

}
