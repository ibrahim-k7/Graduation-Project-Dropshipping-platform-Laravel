<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    //الجدول المربوط به
    protected $table = "store";
    //العناصر
    protected $fillable = [
        'store_id', 'store_name', 'email', 'password', 'phone_number', 'created_at' , 'updated_at',
    ];

    public function wallet()
    {
        return $this->hasOne(Wallet::class,'store_id','store_id');
    }
}
