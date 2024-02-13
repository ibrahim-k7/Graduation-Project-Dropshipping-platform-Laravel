<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    //الجدول المربوط به
    protected $table = "cart";
    //العناصر
    protected $fillable = [
        'cart_id','store_id	','created_at','updated_at'
    ];

   
    //Relations Functhion
    public function store(){
        return $this -> belongsTo(Store::class,'store_id','id');
    }

}
