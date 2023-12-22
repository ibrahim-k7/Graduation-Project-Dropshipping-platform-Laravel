<?php

use Illuminate\Support\Facades\Route;

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

// this file only for user route not the admin route
// هذ الملف للمسارات المتعلقة ب المستخدم وليس الادمن

Route::get('/', function () {
    return view('');
});

