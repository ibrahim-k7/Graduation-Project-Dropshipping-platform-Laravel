<?php
/// app/Models/PurchaseReturn.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Returndetails extends Model
{
    protected $table = "return details";
    protected $primaryKey = 'return_id';

    protected $fillable = [
        'return_id', 'purchase_details_id', 'return_date', 'quantity_returned', 'amount_returned', 'created_at', 'updated_at',
    ];

    public function purchaseDetails()
    {
        return $this->belongsTo(PurchaseDetails::class, 'purchase_details_id', 'id');
    }

}
