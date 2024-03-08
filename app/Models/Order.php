<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_id', 'store_id', 'delivery_id', 'platform', 'payment_status', 'customer_phone',
        'customer_name', 'customer_email', 'shipping_address', 'order_status', 'total_per_shp',
        'total_weight', 'total_amount', 'created_at', 'updated_at'
    ];

    protected $primaryKey = 'order_id';

    protected $attributes = [
        'total_weight' => 0, // Set the default value for total_weight
        'total_amount' => 0, // Set the default value for total_amount
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order details', 'order_id', 'pro_id', 'order_id', 'id');
    }
}
