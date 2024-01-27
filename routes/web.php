<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\auth;
use App\Http\Controllers\user\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// this file only for user routes not the admin routes
// هذ الملف للمسارات المتعلقة ب المستخدم وليس الادمن
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('verified')->group(function(){
    Route::get('user/profile', [ProfileController::class,'index'] )->name('user.profile');
Route::post('user/profile/update-email', [ProfileController::class, 'updateEmail'])->name('profile.updateEmail');
Route::post('user/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // Route::get('user/card', [ProfileController::class,'index'] )->name('user.profile');
    // Route::get('user/setting', [ProfileController::class,'index'] )->name('user.profile');


});

auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/', function () {
    return view('welcome');
});
Route::get('/Dshboard', function () {
    return view('admin/dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
