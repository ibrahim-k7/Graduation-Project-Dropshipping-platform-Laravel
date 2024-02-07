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
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default, this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
{
    return Validator::make($data,
     [
        // 'store_name' => ['required', 'string', 'max:255'],
        // 'email' => ['required', 'string', 'email', 'max:255', 'unique:store,email'],
        // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        // 'phone_number' => ['required', 'string', 'min:9', 'unique:store,phone_number'],
    ], [
        // 'store_name.required' => 'يجب إدخال اسم المتجر.',
        // 'store_name.string' => 'يجب أن يكون اسم المتجر نصًا.',
        // 'store_name.max' => 'اسم المتجر لا يجب أن يتجاوز 255 حرفًا.',
        // 'email.required' => 'يجب إدخال البريد الإلكتروني.',
        // 'email.string' => 'يجب أن يكون البريد الإلكتروني نصًا.',
        // 'email.email' => 'البريد الإلكتروني يجب أن يكون عنوان بريد إلكتروني صالحًا.',
        // 'email.max' => 'البريد الإلكتروني لا يجب أن يتجاوز 255 حرفًا.',
        // 'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',
        // 'password.required' => 'يجب إدخال كلمة المرور.',
        // 'password.string' => 'يجب أن تكون كلمة المرور نصًا.',
        // 'password.min' => 'يجب أن تتكون كلمة المرور على الأقل من 8 أحرف.',
        // 'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        // 'phone_number.required' => 'يجب إدخال رقم الهاتف.',
        // 'phone_number.string' => 'يجب أن يكون رقم الهاتف نصًا.',
        // 'phone_number.min' => 'يجب أن يتكون رقم الهاتف على الأقل من 9 أحرف.',
        // 'phone_number.unique' => 'رقم الهاتف مستخدم بالفعل.',
    ]);
}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // إنشاء المتجر
        $store = Store::create([
            'store_name' => $data['name'],
            'phone_number' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // إنشاء محفظة (wallet) مرتبطة بالمتجر
        $store->wallet()->create([
            'balance' => 0, //  تعيين الرصيد الابتدائي
        ]);

        return $store;
    }
}
