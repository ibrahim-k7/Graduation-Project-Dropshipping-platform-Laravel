<?php

use Illuminate\Support\Facades\Route;

Route::get('/Dshboard', function () {
    return view('admin/dashboard');
});


Route::get('/simple', function () {
    return view('admin/tables_data');
});

Route::get('/wallet', function () {
    return view('admin/wallet');
});

Route::get('/forms-validation', function () {
    return view('admin/forms-validation');
});

Route::get('/login', function () {
    return view('admin/login');
});

Route::get('/register', function () {
    return view('admin/register');
});

    Route::get('/admin-profile', function () {
        return view('admin/admin-profile');
    });

  /* 
Route::prefix('/admin')->group(function () {

   هذا مثال كيف تضيف 
            Routes 
    ب استخدام الكونترولار 
    التزمو فيها لما بكون الكونترولار اللي سويته جاهز
    
   Route::controller(ConsultingController::class)->group(
        function () {

            Route::get('/consulting', 'index')->name('index.Consulting');

            Route::post('/consulting/add', 'store')->name('store.Consulting');

            Route::get('/consulting/edit/{id}', 'edit')->name('edit.Consulting');

            Route::post('/consulting/update/{id}', 'update')->name('update.Consulting');

            Route::get('/consulting/delete/{id}', 'destroy')->name('destroy.Consulting');
        }
    );




});*/
