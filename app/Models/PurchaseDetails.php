<?php
// app/Models/PurchaseDetail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    protected $table = "purchase details";

    protected $fillable = [
        'purchDetails_id', 'purch_id', 'pro_id', 'quantity', 'total_cost', 'created_at', 'updated_at',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purch_id');
    }
}
