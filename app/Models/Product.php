<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    //الجدول المربوط به
    protected $table = "products";
    //العناصر
    protected $fillable = [
        'id','cat_id','subCat_id','name','description','purchasing_price','selling_price','suggested_selling_price','weight','quantity','barcode','image','created_at','updated_at'
    ];


    //Relations Functhion
    public function categorie(){
        return $this -> belongsTo(Categorie::class,'cat_id','id');
    }

    public function subCategorie(){
        return $this -> belongsTo(SubCategorie::class,'subCat_id','id');
    }

    public function cart(){
        return $this-> belongsToMany(Cart::class,'cart_items','pro_id','cart_id','id','cart_id');
    }

    public function order()
    {
        return $this->belongsToMany(Order::class, 'order details', 'pro_id', 'order_id', 'id', 'order_id');
    }
}
