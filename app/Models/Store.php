<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends  Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
   use HasFactory;
    //الجدول المربوط به
    protected $table = "store";
    protected $primaryKey = 'store_id';
    //العناصر
    protected $fillable = [
        'store_id', 'store_name', 'email', 'password', 'phone_number', 'created_at' , 'updated_at',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // تحديث البريد الإلكتروني


    public function updateEmail($email)
    {
        $this->update(['email' => $email]);
    }

    // تحديث كلمة المرور
    public function updatePassword($password)
    {
        $this->update(['password' => bcrypt($password)]);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class,'store_id','store_id');
    }
}
