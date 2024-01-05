<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferInformation extends Model
{
    use HasFactory;

    //الجدول المربوط به
    protected $table = "transfer information";
    //العناصر
    protected $fillable = [
        'transfer_info_id', 'name', 'phone','transfer_network', 'created_at', 'updated_at',
    ];
}
