<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class API extends Model
{
    use HasFactory;
    //الجدول المربوط به
    protected $table = "api";
    //العناصر
    protected $fillable = [
        'id','store_id','domain','secret','key','created_at','updated_at',
    ];

    //Relations Functhion
    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','store_id');
    }

}
