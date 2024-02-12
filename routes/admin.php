<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseDetailsController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\AdminInfoController;
use App\Http\Controllers\ReturnDetailsOrderController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SubCategorieController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierTransactionController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TransferInformationController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletOperationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\auth\AdminLoginController;
use App\Http\Controllers\admin\auth\AdminRegisterController;
use App\Http\Controllers\admin\AdminDshboardController;
use App\Http\Controllers\admin\AdminProfileController;

Route::middleware('auth:admin')->group(function(){
    Route::get('admin/dshboard',[AdminDshboardController::class,'index'])->name('admin.dshboard');
    Route::get('admin/dshboard/getstoreCount',[AdminDshboardController::class,'getstoreCount'])->name('admin.dshboard.getstoreCount');
    Route::get('admin/dshboard/getChartData',[AdminDshboardController::class,'getChartData'])->name('admin.dshboard.getChartData');
    Route::get('admin/dshboard/calculateChartTrafData',[AdminDshboardController::class,'calculateChartTrafData'])->name('admin.dshboard.calculateChartTrafData');

});

Route::prefix('/admin')->group(function () {

    Route::controller(ProductController::class)->group(
        function () {
            Route::get('/products_management','index')->name('admin.products');
            Route::get('/products_management/data','getDataTable')->name('admin.products.data');
            Route::get('/products_management/create', 'create')->name('admin.products.create');
            Route::get('/products_management/edit', 'edit')->name('admin.products.edit');
            Route::post('/products_management/store', 'store')->name('admin.products.store');
            Route::post('/products_management/update', 'update')->name('admin.products.update');
            Route::post('/products_management/destroy','destroy')->name('admin.products.destroy');
            Route::get('/products_management/getProductsCount','getProductsCount')->name('admin.products.getProductsCount');
            Route::get('/products_management/getLowQuantityProducts','getLowQuantityProducts')->name('admin.products.getLowQuantityProducts');
        }
    );
    // user information
    Route::controller(UserInfoController::class)->group(
        function () {
            Route::get('/user-information','index')->name('admin.users');
            Route::get('/user-information/data','getDataTable')->name('admin.users.data');


        }
    );
      // admin information
      Route::controller(AdminInfoController::class)->group(
        function () {
            Route::get('/admin-information','index')->name('admin.admin');
            Route::get('/admin-information/data','getDataTable')->name('admin.admins.data');


        }
    );

    //  Delivery
    Route::controller(DeliveryController::class)->group(
        function () {
            Route::get('/delivery_management','index')->name('admin.delivery');
            Route::get('/delivery_management/a','getDataTable')->name('admin.delivery.data');
            Route::get('/insert_delivery' ,'create')->name('admin.delivery.insert');
            Route::post('/add_delivery','store')->name('admin.delivery.store');
            Route::get('/edit_delivery','edit')->name('admin.delivery.edit');
            Route::post('/update_delivery','update')->name('admin.delivery.update');
            Route::post('/destroy_delivery','destroy')->name('admin.delivery.delete');
        }
    );

    //Order
    Route::controller(OrderController::class)->group(
        function () {
            Route::get('/order_management','index')->name('admin.order');
            Route::get('/order_managment/a','getDataTable')->name('admin.order.data');
            Route::post('/order_managment/updatePayment','updatePaymentStatus')->name('admin.order.update.payment.status');
            Route::post('/order_managment/updateOrder','updateOrderStatus')->name('admin.order.update.order.status');
            Route::post('/order_managment/delete','destroy')->name('admin.order.destroy');
            Route::get('/order_managment/getOrders', 'getOrders')->name('admin.order.getOrders');// اعادة المنتجات لعرضها في واجهة لوحة التحكم
            Route::get('/order_managment/getOrdersCount', 'getOrdersCount')->name('admin.order.getOrdersCount'); //إرجاع عددالطلبات لواجهة لوحة التحكم
            Route::get('/order_managment/getTotalPaidOrdersAmount', 'getTotalPaidOrdersAmount')->name('admin.order.getTotalPaidOrdersAmount'); //إرجاع إجمالي المبيعات لواجهة لوحة التحكم

        }
    );

    //Order Details
    Route::controller(OrderDetailsController::class)->group(
        function () {
            Route::get('/order_details_managment','index')->name('admin.order.details');
            Route::get('/order_details_managment/a','getDataTable')->name('admin.order.details.data');
            Route::get('/order_details_managment/return','return')->name('admin.order.details.return');

        }
    );

    //Returned Order Details
    Route::controller(ReturnDetailsOrderController::class)->group(
        function () {
            Route::get('/return_order_details_managment','index')->name('admin.returned.order.details');
            Route::get('/return_order_details_managment/a','getDataTable')->name('admin.returned.order.details.data');
            Route::post('/return_order_details_managment/store','store')->name('admin.returned.order.details.store');
            Route::post('/return_order_details_managment/update','update')->name('admin.returned.order.details.update');
            Route::get('/return_order_details_managment/edit','edit')->name('admin.returned.order.details.edit');

        }
    );

    //Sales
    Route::controller(SalesController::class)->group(
        function () {
            Route::get('/sales_managment','index')->name('admin.sales');
            Route::get('/sales_managment/a','getDataTable')->name('admin.sales.data');
        }
    );

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
            Route::get('/suppliers_management/getSuppliersCount', 'getSuppliersCount')->name('admin.suppliers.getSuppliersCount');// عدد الموردين
            Route::get('/suppliers_management/getSuppliersTotalBalance', 'getSuppliersTotalBalance')->name('admin.suppliers.getSuppliersTotalBalance');// حساب المديونية


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

    Route::controller(CategorieController::class)->group(
        function () {
            Route::get('/Categories', 'index')->name('admin.categories');
            Route::get('/Categories/data', 'getDataTable')->name('admin.categories.data');
            Route::get('/Categories/create', 'create')->name('admin.categories.create');
            Route::get('/Categories/edit', 'edit')->name('admin.categories.edit');
            Route::get('/Categories/getCategories', 'getCategories')->name('admin.Categories.getCategories');
            Route::get('/Categories/getSubCategories', 'getSubCategories')->name('admin.Categories.getSubCategories');
            Route::post('/Categories/store', 'store')->name('admin.categories.store');
            Route::post('/Categories/update', 'update')->name('admin.categories.update');
            Route::post('/Categories/destroy', 'destroy')->name('admin.categories.destroy');
        }
    );

    Route::controller(SubCategorieController::class)->group(
        function () {
            Route::get('/SubCategories', 'index')->name('admin.subCategories');
            Route::get('/SubCategories/data', 'getDataTable')->name('admin.subCategories.data');
            Route::get('/SubCategories/create', 'create')->name('admin.subCategories.create');
            Route::get('/SubCategories/edit', 'edit')->name('admin.subCategories.edit');
            Route::post('/SubCategories/store', 'store')->name('admin.subCategories.store');
            Route::post('/SubCategories/update', 'update')->name('admin.subCategories.update');
            Route::post('/SubCategories/destroy', 'destroy')->name('admin.subCategories.destroy');
        }
    );
});


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
    Route::get('admin/supplier/getSuppliers', [SupplierController::class, 'getSuppliers'])->name('admin.supplier.getSuppliers');

    // Purchase Routes
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('admin.purchase.index');
    Route::get('/purchase/data', [PurchaseController::class, 'getDataTable'])->name('admin.purchase.data');
    Route::get('/purchase/create', [PurchaseController::class, 'create'])->name('admin.purchase.create');
    Route::post('/purchase/store', [PurchaseController::class, 'store'])->name('admin.purchase.store');
    Route::get('/Purchase_edit', [PurchaseController::class, 'edit'])->name('admin.Purchase.edit');
    Route::post('/purchase/update', [PurchaseController::class, 'update'])->name('admin.purchase.update');
    // روت لعرض صفحة استرجاع المشتريات
    Route::get('/admin/purchase/returnDetails', [PurchaseController::class, 'returnDetails'])
        ->name('admin.purchase.returnDetails');

// روت لمعالجة عملية الاسترجاع
    Route::post('/admin/purchase/processReturn', [PurchaseController::class, 'processReturn'])
        ->name('admin.purchase.processReturn');

    Route::get('admin/purchase/getPurchaseInvoices', [PurchaseController::class, 'getPurchaseInvoices'])->name('admin.purchase.getPurchaseInvoices');


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


    Route::get('/admin-profile', function () {
        return view('admin/admin-profile');
    });
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/admin/profile', [AdminProfileController::class,'showProfile'])->name('admin.profile');
        Route::post('/admin/profile/update-email',  [AdminProfileController::class,'updateEmail'])->name('profile.updateEmail');
        Route::post('/admin/profile/update-password',  [AdminProfileController::class,'updatePassword'])->name('profile.updatePassword');
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
