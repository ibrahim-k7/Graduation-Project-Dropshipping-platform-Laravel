<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    //الجدول المربوط به
    protected $table = "wallet";
    //العناصر
    protected $fillable = [
        'wallet_id', 'balance', 'created_at', 'updated_at',
    ];
            //Relations Functhion
        public function store(){
            return $this -> belongsTo('App\Models\Store','store_id ');
        }
}
