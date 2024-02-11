<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerProduct extends Model
{
    use HasFactory;

    // الجدول المربوط به
    protected $table = "dealer products";
    // العناصر
    protected $fillable = ['dealer_pro_id', 'store_id', 'pro_id', 'dealer_selling_price', 'dealer_product_name', 'dealer_product_desc', 'platform', 'created_at', 'updated_at'];

        public function product()
    {
        return $this->belongsTo(Product::class, 'pro_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
