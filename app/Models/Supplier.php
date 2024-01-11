<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    //الجدول المربوط به
    protected $table = "suppliers";
    //العناصر
    protected $fillable = [
<<<<<<< HEAD
        'sup_id','name','email','address','phone_number','created_at','updated_at'
    ];

=======
        'sup_id','name','email','address','phone_number','balance','created_at','updated_at'
    ];

    public function SuplierTransactions(){
        return $this -> hasMany('App\Models\SupplierTransaction','sup_id','sup_id');
    }

    public function SuplierPurchases(){
        return $this -> hasMany(Purchase::class,'sup_id','sup_id');
    }

>>>>>>> fad06c427242629c39afca398ff220bb11b23866
}
