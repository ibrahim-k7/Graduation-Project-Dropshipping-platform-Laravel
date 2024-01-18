<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class AdminLoginController extends Controller
{
    //
    protected $redirectTo = RouteServiceProvider::AdminHome;

    public function __construct(){
        $this->middleware('guest:admin')->except('logout');
    }

    public function login(){
        return view('Admin.auth.login');
    }
    public function checkLogin(Request $request){
        // logic
        $request->validate([
            "email" => ["required","string"],
            "password" =>["required","string"]
        ]);

        if(Auth::guard('admin')->attempt($request->only('email','password'), $request->get('remember'))){
          return redirect()->intended($this->redirectTo);
        }else{
            return redirect()->back()->withInput(['email'=>$request->email])
            ->withErrors(['errorResponse'=>'this credentials do not  match our records']);
        }
    }


    public function logout(){
        Auth::guard('admin')->logout();
         return redirect()->route('admin.dshboard.login');

    }
}
