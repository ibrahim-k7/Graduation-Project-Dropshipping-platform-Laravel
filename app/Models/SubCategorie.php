<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategorie extends Model
{
    use HasFactory;
    protected $table = "sub categories";

    protected $fillable = [
        'id','name','cat_id','created_at','updated_at',
    ];

    public function categorie(){
        return $this ->belongsTo(Categorie::class,'cat_id' ,'id');
    }
}
