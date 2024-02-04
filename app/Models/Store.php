<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Store extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    // تعيين اسم الجدول
    protected $table = 'store';

    // تعيين العمود الرئيسي
    protected $primaryKey = 'store_id';

    // الحقول التي يمكن تعبئتها
    protected $fillable = [
        'store_id',
        'store_name',
        'email',
        'password',
        'phone_number',
    ];

    // الحقول المخفية
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // تحويل التواريخ إلى نوع محدد
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
}
