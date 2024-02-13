<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;




class AdminRegisterController extends Controller
{

    //
    public function register()
    {
        return view('Admin.auth.register');
    }
    public function store(Request $request)
    {
        // logicاضافة تحقق وقيود لل ايميل وكلمة السر
        $adminkey = "adminkey1";
        if ($request->admin_key == $adminkey) {
            $request->validate([
                "name" => ['required', 'string', 'max:255'],
                "email" => ["required", "regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", "unique:store"],
                "admin_key" => ["required", "string"],
                'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
                "password_confirmation" => ["required", "string"]
            ]);
            $date = $request->except(['password_confirmation','_token','admin_key']);
            $date['password'] = Hash::make($request->password);
            Admin::create($date);
            return redirect()->route('admin.dshboard.login');


        } else {
            return redirect()->back()->with('errorResponse', 'something went wrong');
        }
    }
}
