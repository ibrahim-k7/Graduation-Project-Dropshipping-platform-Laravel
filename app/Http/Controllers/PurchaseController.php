<?php
// app/Models/Purchase.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = "purchases";

    protected $fillable = [
        'id','sup_id', 'payment_method', 'additional_costs', 'total', 'amount_paid', 'created_at', 'updated_at',
    ];

    public function prouduct(){
        return $this-> belongsToMany(Product::class,'purchase details','purch_id','pro_id','id','id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'sup_id', 'sup_id');

    }
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class, 'purch_id', 'id');
    }


}
