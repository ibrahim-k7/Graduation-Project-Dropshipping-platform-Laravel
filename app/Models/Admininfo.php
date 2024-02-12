<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admininfo extends Model
{
    use HasFactory;

    protected $table = "admins";
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'name', 'email','created_at'
    ];
}

