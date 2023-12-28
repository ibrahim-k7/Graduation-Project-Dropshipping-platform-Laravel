<?php

use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/Dshboard', function () {
    return view('admin/dashboard');
});

/*Route::get('/suppliers_management', function () {
    return view('admin/suppliers_management');
});*/

Route::get('/suppliers_management', [SupplierController::class, 'index'])->name('admin.suppliers');
Route::get('/suppliers_management/a', [SupplierController::class, 'getDataTable'])->name('admin.suppliers.data');
Route::post('/suppliers_store', [SupplierController::class, 'store'])->name('admin.suppliers.store');
Route::get('/create_supplire', [SupplierController::class, 'create'])->name('admin.suppliers.create');

Route::get('/suppiler_transaction', [SupplierTransactionController::class, 'index'])->name('admin.suppliers.transaction');
Route::get('/suppiler_transaction/data', [SupplierTransactionController::class, 'getDataTable'])->name('admin.suppliers.transaction.data');
Route::get('/create_supplire_transaction', [SupplierTransactionController::class, 'create'])->name('admin.supplier.transaction.create');
Route::post('/supplier_transaction_store', [SupplierTransactionController::class, 'store'])->name('admin.supplier.transaction.store');



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
    
   Route::controller(SupplierController::class)->group(
        function () {

            Route::get('/suppliers_management', 'index')->name('admin.suppliers');

            Route::post('/suppliers_management', 'getDataTable')->name('admin.suppliers.data');

            Route::get('/consulting/edit/{id}', 'edit')->name('edit.Consulting');

            Route::post('/consulting/update/{id}', 'update')->name('update.Consulting');

            Route::get('/consulting/delete/{id}', 'destroy')->name('destroy.Consulting');
        }
    );




});*/
