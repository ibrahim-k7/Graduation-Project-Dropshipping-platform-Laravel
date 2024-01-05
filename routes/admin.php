<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseDetailsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierTransactionController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TransferInformationController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletOperationController;
use Illuminate\Support\Facades\Route;

Route::get('/Dshboard', function () {
    return view('admin/dashboard');
});

/*Route::get('/suppliers_management', function () {
    return view('admin/suppliers_management');
});*/

Route::prefix('/admin')->group(function () {

    Route::controller(SupplierController::class)->group(
        function () {
            Route::get('/suppliers_management', 'index')->name('admin.suppliers');
            Route::get('/suppliers_management/data', 'getDataTable')->name('admin.suppliers.data');
            Route::get('/suppliers_management/create', 'create')->name('admin.suppliers.create');
            Route::get('/suppliers_management/edit', 'edit')->name('admin.suppliers.edit');
            Route::get('/suppliers_management/getSuppliers', 'getSuppliers')->name('admin.suppliers.getSuppliers');
            Route::post('/suppliers_management/store', 'store')->name('admin.suppliers.store');
            Route::post('/suppliers_management/destroy', 'destroy')->name('admin.suppliers.destroy');
            Route::post('/suppliers_management/update', 'update')->name('admin.suppliers.update');
        }
    );

    Route::controller(SupplierTransactionController::class)->group(
        function () {
            Route::get('/suppilers_transactions', 'index')->name('admin.suppliers.transactions');
            Route::get('/suppilers_transactions/data', 'getDataTable')->name('admin.suppliers.transactions.data');
            Route::get('/suppilers_transactions/create', 'create')->name('admin.suppliers.transactions.create');
            Route::get('/suppilers_transactions/edit', 'edit')->name('admin.suppliers.transactions.edit');
            Route::post('/suppilers_transactions/store', 'store')->name('admin.suppliers.transactions.store');
            Route::post('/suppilers_transactions/destroy', 'destroy')->name('admin.suppliers.transactions.destroy');
            Route::post('/suppilers_transactions/update', 'update')->name('admin.suppliers.transactions.update');
        }
    );

    Route::controller(WalletController::class)->group(
        function () {
            Route::get('/wallet_management', 'index')->name('admin.wallets');
            Route::get('/wallet_management/data', 'getDataTable')->name('admin.wallets.data');
            Route::get('/wallet_management/getWallets', 'getWallets')->name('admin.wallets.getWallets');
        }
    );

    Route::controller(TransferInformationController::class)->group(
        function () {
            Route::get('/transfer_info', 'index')->name('admin.transfer.info');
            Route::get('/transfer_info/data', 'getDataTable')->name('admin.transfer.info.data');
            Route::get('/transfer_info/create', 'create')->name('admin.transfer.info.create');
            Route::get('/transfer_info/edit', 'edit')->name('admin.transfer.info.edit');
            Route::post('/transfer_info/store', 'store')->name('admin.transfer.info.store');
            Route::post('/transfer_info/update', 'update')->name('admin.transfer.info.update');
            Route::post('/transfer_info/destroy', 'destroy')->name('admin.transfer.info.destroy');
        }
    );



});

//Route::get('/suppliers_management', [SupplierController::class, 'index'])->name('admin.suppliers');
//Route::get('/suppliers_management/data', [SupplierController::class, 'getDataTable'])->name('admin.suppliers.data');
//Route::post('/suppliers_store', [SupplierController::class, 'store'])->name('admin.suppliers.store');
//Route::get('/create_supplire', [SupplierController::class, 'create'])->name('admin.suppliers.create');
//Route::post('/supplier_destroy', [SupplierController::class, 'destroy'])->name('admin.supplier.destroy');
//Route::get('/supplier_edit', [SupplierController::class, 'edit'])->name('admin.supplier.edit');
//Route::post('/supplier_update', [SupplierController::class, 'update'])->name('admin.supplier.update');
//Route::get('admin/supplier/getSuppliers', [SupplierController::class, 'getSuppliers'])->name('admin.supplier.getSuppliers');

//Route::get('/suppiler_transaction', [SupplierTransactionController::class, 'index'])->name('admin.suppliers.transaction');
//Route::get('/suppiler_transaction/data', [SupplierTransactionController::class, 'getDataTable'])->name('admin.suppliers.transaction.data');
//Route::get('/create_supplire_transaction', [SupplierTransactionController::class, 'create'])->name('admin.supplier.transaction.create');
//Route::post('/supplier_transaction_store', [SupplierTransactionController::class, 'store'])->name('admin.supplier.transaction.store');
//Route::post('/supplier_transaction_destroy', [SupplierTransactionController::class, 'destroy'])->name('admin.supplier.transaction.destroy');
//Route::get('/supplier_transaction_edit', [SupplierTransactionController::class, 'edit'])->name('admin.supplier.transaction.edit');
//Route::post('/supplier_transaction_update', [SupplierTransactionController::class, 'update'])->name('admin.supplier.transaction.update');

//Route::get('/wallet_management', [WalletController::class, 'index'])->name('admin.wallets');
//Route::get('/wallet_management/data', [WalletController::class, 'getDataTable'])->name('admin.wallets.data');
//Route::get('/wallet/getWallets', [WalletController::class, 'getWallets'])->name('admin.wallets.getWallets');

Route::get('/wallet_operation', [WalletOperationController::class, 'index'])->name('admin.wallets.operation');
Route::get('/wallet_operation/data', [WalletOperationController::class, 'getDataTable'])->name('admin.wallets.operation.data');
Route::get('/wallet_operation/create', [WalletOperationController::class, 'create'])->name('admin.wallets.operation.create');
Route::post('/wallet_operation/store', [WalletOperationController::class, 'store'])->name('admin.wallets.operation.store');
Route::get('/wallet_operation/edit', [WalletOperationController::class, 'edit'])->name('admin.wallets.operation.edit');
Route::post('/wallet_operation/update', [WalletOperationController::class, 'update'])->name('admin.wallets.operation.update');
Route::post('/wallet_operation/destroy', [WalletOperationController::class, 'destroy'])->name('admin.wallets.operation.destroy');

Route::get('/transfers', [TransferController::class, 'index'])->name('admin.transfers');
Route::get('/transfers_management/data', [TransferController::class, 'getDataTable'])->name('admin.transfers.data');
Route::post('/transfers/update', [TransferController::class, 'update'])->name('admin.transfers.update');
Route::post('/transfers/destroy', [TransferController::class, 'destroy'])->name('admin.transfers.destroy');

Route::prefix('admin')->group(function () {


    Route::get('admin/product/getProducts', [ProductController::class, 'getProducts'])->name('admin.product.getProducts');


    // Purchase Routes
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('admin.purchase.index');
    Route::get('/purchase/data', [PurchaseController::class, 'getDataTable'])->name('admin.purchase.data');
    Route::get('/purchase/create', [PurchaseController::class, 'create'])->name('admin.purchase.create');
    Route::post('/purchase/store', [PurchaseController::class, 'store'])->name('admin.purchase.store');
    Route::get('/purchase/edit/{id}', [PurchaseController::class, 'edit'])->name('admin.purchase.edit');
    Route::put('/purchase/update/{id}', [PurchaseController::class, 'update'])->name('admin.purchase.update');

    // Purchase Details Routes
    Route::get('/purchase-details/data', [PurchaseDetailsController::class, 'getDataTable'])->name('admin.purchasedetails.data');

    // Return Purchase Routes
    Route::get('/purchase/return', [PurchaseController::class, 'return'])->name('admin.purchase.return');
    Route::post('/purchase/process-return', [PurchaseController::class, 'processReturn'])->name('admin.purchase.processReturn');

    // Missing Purchase Data Route
    // Route::get('/purchase/data', [PurchaseController::class, 'getData'])->name('admin.purchase.data');
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
