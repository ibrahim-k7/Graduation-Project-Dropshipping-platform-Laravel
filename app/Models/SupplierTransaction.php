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
<<<<<<< HEAD
        'transaction_id','balance','amount','transaction_type','created_at','updated_at'
    ];

    /*public function supplier(){
        return $this -> hasOne('App\Models\Supplier','sup_id ');
    }*/
=======
        'transaction_id','sup_id','amount','transaction_type','created_at','updated_at'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'sup_id', 'sup_id');
    }
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
}
