<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
<<<<<<< HEAD
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// this file only for user routes not the admin routes
// هذ الملف للمسارات المتعلقة ب المستخدم وليس الادمن
=======
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/Dshboard', function () {
    return view('admin/dashboard');
});
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
