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

    public function purchase(){
        return $this-> belongsToMany(Purchase::class,'purchase details','pro_id','purch_id','id','id');
    }
}
