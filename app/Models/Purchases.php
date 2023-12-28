<?php
// app/Models/Purchase.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = "Purchase";

    protected $fillable = [
        'purch_ID', 'payment_method', 'sup_ID', 'Extra_expenses', 'total', 'Amount_paid', 'created_at', 'updated_at',
    ];

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class, 'purch_id');
    }
}
