<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletOperation extends Model
{
    use HasFactory;
    //الجدول المربوط به
    protected $table = "wallet operations";
    //العناصر
    protected $fillable = [
        'wallet_operation_id', 'wallet_id', 'operation_type', 'amount', 'balance_aft_transfer', 'details', 'created_at', 'updated_at',
    ];

    //Relations Functhion

    public function wallet(){
        return $this -> belongsTo(Wallet::class,'wallet_id','wallet_id');
    }

}
