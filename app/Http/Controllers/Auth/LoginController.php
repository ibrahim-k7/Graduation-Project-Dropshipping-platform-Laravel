<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        if(Auth::guard('admin')->check()){
            Auth::guard()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            if ($response = $this->loggedOut($request)) {
                return $response;
            }

            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect()->route('admin.dshboard.login');

        }else{
            $this->guard()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            if ($response = $this->loggedOut($request)) {
                return $response;
            }

            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect()->route('login');
        }

    }

    public function username()
    {
        $value = request()->input('userLogin');
        if(filter_var($value,FILTER_VALIDATE_EMAIL)){
            request()->merge(['email'=> $value]);
            return 'email';
        }elseif(preg_match("/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/ ", $value )){
            request()->merge(['name'=> $value]);
            return 'name';
        }elseif(preg_match("/^(((\+|00)9677|0?7)[01378]\d{7}|((\+|00)967|0)[1-7]\d{6})$/", $value )){
            request()->merge(['phone'=> $value]);
            return 'phone';
        }else{
            request()->merge(['email'=> $value]);
            return 'email';
        }
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'userLogin' => 'required|string',
            'password' => 'required|string',
        ],[
                "userLogin.required"=>"the phone / email/ name is required",
        ]);
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        $userLoginField = $this->username();

        if ($userLoginField === 'email') {
            throw ValidationException::withMessages([
                'userLogin' => [trans('كلمة السر او الايميل او اسم المستخدم غير صحيح')],
            ]);
        } else {
            throw ValidationException::withMessages([
                'userLogin' => [trans('auth.failed')],
            ]);
        }
    }
}


