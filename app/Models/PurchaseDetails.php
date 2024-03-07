<?php
//app/Models/PurchaseDetailsController.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    protected $table = "purchase details";

    protected $fillable = [
        'id',  'purch_id', 'pro_id', 'quantity', 'total_cost', 'created_at', 'updated_at',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'pro_id', 'id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purch_id', 'id');
    }
    public function returnDetails()
    {
        return $this->hasMany(Returndetails::class, 'purchase_details_id', 'id');
    }

}
