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
        'sup_id','name','email','address','phone_number','created_at','updated_at'
    ];

}
