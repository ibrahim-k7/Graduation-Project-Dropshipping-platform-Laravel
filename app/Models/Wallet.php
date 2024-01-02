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
        'wallet_id','store_id','balance','created_at','updated_at',
    ];
    
    //Relations Functhion
    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','store_id');
    }

    //Relations Functhion
    public function walletOperations(){
        return $this -> hasMany(WalletOperation::class,'wallet_id','wallet_id');
    }

    public function walletTransfers(){
        return $this -> hasMany(Transfer::class,'wallet_id','wallet_id');
    }
}
