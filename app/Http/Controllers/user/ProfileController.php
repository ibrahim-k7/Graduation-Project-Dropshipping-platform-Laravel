<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Store; // تضمين النموذج Store

class ProfileController extends Controller
{
    // عرض صفحة الملف الشخصي
    public function index()
    {
        return view('user.profile');
    }

    // تحديث البريد الإلكتروني
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:store,email,NULL,id,store_id,' . Auth::id(),
        ]);

        Auth::user()->update(['email' => $request->email]);

        return redirect()->back()->with('message', 'Email updated successfully.');
    }

    // تحديث كلمة المرور
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('message', 'Password updated successfully.');
    }

    // تحديث رقم الهاتف
    public function updatePhoneNumber(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|min:9|max:9', // يجب أن يكون الرقم بين 10 و 15 حرفًا
        ]);

        Auth::user()->update(['phone_number' => $request->phone_number]);

        return redirect()->back()->with('message', 'Phone number updated successfully.');
    }
}
