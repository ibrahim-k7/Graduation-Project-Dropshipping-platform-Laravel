<?php

use Illuminate\Support\Facades\Route;

Route::get('/Dshboard', function () {
    return view('admin/index');
});

Route::get('/Wallet', function () {
    return view('admin/tables_data');
});

Route::get('/forms-validation', function () {
    return view('admin/forms-validation');
});