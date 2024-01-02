<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    //الجدول المربوط به
    protected $table = "transfer";
    //العناصر
    protected $fillable = [
        'transfer_id', 'wallet_id', 'sender_name','sender_phone','amount_transferred','transfer_number','transfer_date','transfer_status' ,'transfer_image', 'created_at', 'updated_at',
    ];

    //Relations Functhion
    public function wallet(){
        return $this -> belongsTo(Wallet::class,'wallet_id','wallet_id');
    }
}
