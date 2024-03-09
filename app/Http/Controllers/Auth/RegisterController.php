<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Store;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data,
            [
                'store_name' => ['required', 'string', 'max:255'],
                'email' => ["required", "email", "unique:store"], // تحديد صيغة البريد الإلكتروني وأنه فريد
                'password' => ['required', 'min:8', 'confirmed'],
                "password_confirmation" => ["required", "string"],
                'phone_number' => ['required', 'string', 'max:9','min:9','regex:/^(((\+|00)9677|0?7)[01378]\d{7}|((\+|00)967|0)[1-7]\d{6})$/', 'unique:store'],
            ], [
                'store_name.required' => 'يجب إدخال اسم المتجر.',
                'email.required' => 'يجب إدخال البريد الإلكتروني.',
                'email.email' => 'البريد الإلكتروني يجب أن يكون عنوان بريد إلكتروني صالحًا.',
                'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',
                'password.required' => 'يجب إدخال كلمة المرور.',
                'password.min' => 'يجب أن تتكون كلمة المرور على الأقل من 8 أحرف.',
                'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
                'phone_number.required' => 'يجب إدخال رقم الهاتف.',
                'phone_number.max' => 'يجب أن يتكون رقم الهاتف  من 9 ارقام.',
                'phone_number.min' => 'يجب أن يتكون رقم الهاتف  من 9 ارقام.',
                'phone_number.unique' => 'رقم الهاتف مستخدم بالفعل.',
            ]);
    }

    protected function create(array $data)
    {
        // إنشاء المتجر
        $store = Store::create([
            'store_name' => $data['store_name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // إنشاء محفظة (wallet) مرتبطة بالمتجر
        $store->wallet()->create([
            'balance' => 0, //  تعيين الرصيد الابتدائي
        ]);
        $store->cart()->create([]); // إنشاء سلة المشتريات

        return $store;
    }
}
