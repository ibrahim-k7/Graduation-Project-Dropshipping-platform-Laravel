<?php
// app/Models/PurchaseDetails.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    protected $table = "purchase details";

    protected $fillable = [
        'purch_id', 'pro_id', 'quantity', 'total_cost', 'created_at', 'updated_at',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'pro_id', 'id')
            ->select('id', 'purchasing_price') // اختيار الحقل purchasing_price من جدول المنتجات
            ->withPivot('quantity', 'total_cost');
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purch_id', 'id');
    }
}
