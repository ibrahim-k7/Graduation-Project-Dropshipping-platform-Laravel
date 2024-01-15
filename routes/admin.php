<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\auth\AdminLoginController;
use App\Http\Controllers\admin\auth\AdminRegisterController;
use App\Http\Controllers\admin\AdminDshboardController;
use App\Http\Controllers\admin\AdminProfileController;







// Route::get('/Dshboard', function () {
//     return view('admin/dashboard');
// });

/*Route::get('/suppliers_management', function () {
    return view('admin/suppliers_management');
});*/

Route::get('/suppliers_management', [SupplierController::class, 'index'])->name('admin.suppliers');
Route::get('/suppliers_management/a', [SupplierController::class, 'getDataTable'])->name('admin.suppliers.data');
Route::post('/suppliers_store', [SupplierController::class, 'store'])->name('admin.suppliers.store');
Route::get('/create_supplire', [SupplierController::class, 'create'])->name('admin.suppliers.create');

Route::get('/simple', function () {
    return view('admin/tables_data');
});

Route::get('/wallet', function () {
    return view('admin/wallet');
});

Route::get('/forms-validation', function () {
    return view('admin/forms-validation');
});
// Route::get('/profile', function () {
//     return view('admin/profile');
//  });
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/profile', [AdminProfileController::class,'showProfile'])->name('admin.profile');
    Route::post('/admin/profile/update-email',  [AdminProfileController::class,'updateEmail'])->name('profile.updateEmail');
    Route::post('/admin/profile/update-password',  [AdminProfileController::class,'updatePassword'])->name('admin.profile.updatePassword');
});


 Route::middleware('auth:admin')->group(function(){
    Route::get('admin/dshboard',[AdminDshboardController::class,'index'])->name('admin.dshboard');
});

Route::prefix('admin/dshboard')->name('admin.dshboard.')->group(function(){
Route::controller(AdminLoginController::class)->group(function(){
    Route::get('login','login')->name('login');
    Route::post('login','checkLogin')->name('check');
    Route::post('logout','logout')->name('logout');
});
Route::controller(AdminRegisterController::class)->group(function(){
    Route::get('register','register')->name('register');
    Route::post('register','store')->name('store');
});

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
