<?php
/// app/Models/PurchaseReturn.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    protected $table = "return details";

    protected $fillable = [
        'return_id', 'purchase_details_id', 'return_date', 'quantity_returned', 'amount_returned', 'created_at', 'updated_at',
    ];

    public function purchaseDetail()
    {
        return $this->belongsTo(PurchaseDetail::class, 'purchase_details_id');
    }
}
