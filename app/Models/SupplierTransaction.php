<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierTransaction extends Model
{
    use HasFactory;
    //الجدول المربوط به
    protected $table = "supplier transaction";
    //العناصر
    protected $fillable = [
        'transaction_id','sup_id','balance','amount','transaction_type','created_at','updated_at'
    ];

    public function supplier(){
        return $this -> belongsTo('App\Models\Supplier','sup_id ','sup_id');
    }
}
