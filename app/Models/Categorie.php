<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $table = "categories";

    protected $fillable = [
        'id','name', 'created_at', 'updated_at',
    ];

    public function supCat(){
        return $this ->hasMany(SubCategorie::class,'cat_id' ,'id');
    }

}
