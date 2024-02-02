<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
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
    | validation and creation. By default this controller uses a trait to
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
        return Validator::make($data, [
            // 'store_name' => ['required', 'string', 'max:255'],
            // "email" => ["required", "regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", "unique:admins"],
            // 'password' => ['required', 'min:8','string','confirmed'],
            // 'phone_number' => ['required', 'regex:/^(((\+|00)9677|0?7)[01378]\d{7}|((\+|00)967|0)[1-7]\d{6})$/', 'min:9', 'unique:users'],

            // 'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],

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
        return store::create([
            'store_name' => $data['name'],
            'phone_number' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // protected function customMessages()
    // {
    //     return [
    //         'email.regex' => 'The email must have a valid format.',
    //         'password.regex' => 'The password must be at least 8 characters and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.',
    //         'phone.regex' => 'The phone number must have a valid format.',
    //     ];}
}
