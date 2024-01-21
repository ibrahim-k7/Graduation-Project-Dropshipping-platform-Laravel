<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    
    // الجدول المرتبط به
    protected $table = "delivery";
    // العناصر 
    protected $fillable = ['delivery_id', 'name' , 'shipping_fees', 'created_at', 'updated_at'];
}
