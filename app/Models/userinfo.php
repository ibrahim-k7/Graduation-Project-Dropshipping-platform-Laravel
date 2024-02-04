<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userinfo extends Model
{
    use HasFactory;

    protected $table = "store";

    protected $fillable = [
        'store_id', 'store_name', 'phone_number', 'email','created_at'
    ];
}

