<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerProduct extends Model
{
    use HasFactory;

    // الجدول المربوط به
    protected $table = "purchase details";
    // العناصر
    protected $fillable = ['dealer_pro_id', 'store_id', 'pro_id', 'dealer_selling_price', 'dealer_product_name', 'dealer_product_desc', 'platform', 'created_at', 'updated_at'];
}
