<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ReturnDetailsOrder extends Model
{
    use HasFactory;

    protected $table = 'return details order';

    protected $fillable = ['return_id', 'order_details_id', 'return_date', 'quantity_returned', 'amount_returned',
        'created_at', 'updated_at'];
}
