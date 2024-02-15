<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TransferInformationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\auth;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletOperationController;
use App\Http\Controllers\DealerProductController;



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
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('auth/login');
});



Route::middleware('verified')->group(function () {
    Route::get('user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('user/profile/update-email', [ProfileController::class, 'updateEmail'])->name('user.profile.updateEmail');
    Route::post('user/profile/update-password', [ProfileController::class, 'updatePassword'])->name('user.profile.updatePassword');
    // Route::get('user/card', [ProfileController::class,'index'] )->name('user.profile');
    // Route::get('user/setting', [ProfileController::class,'index'] )->name('user.profile');

    Route::get('/Dshboard', function () {
        return view('User.Dashboard.dashboard');
    })->name('user.dashboard');
});
auth::routes(['verify' => true]);

// Route::get('user/home', [App\Http\Controllers\HomeController::class, 'index'])->name('user.home');




Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/userinterface', function () {
    return view('User.Dashboard.dashboard');
});

//product catalogue
Route::controller(ProductController::class)->group(
    function () {
        Route::get('/catalogue', 'getAllProducts')->name('user.products.catalogue');
    }
);

//product details
Route::controller(ProductController::class)->group(
    function () {
        Route::get('/details/{id}', 'getProductDetails')->name('user.product.details');
    }
);

//Seller products
Route::controller(DealerProductController::class)->group(
    function () {
        Route::get('/user/products', 'show')->name('seller.products');
        Route::get('/user/products/data', 'getDataTable')->name('seller.products.data');
        Route::get('/user/create', 'create')->name('user.dealer.product.details');
        Route::post('/user/store', 'store')->name('user.add.dealer.product');
        Route::post('/user/destroy', 'destroy')->name('user.dealer.product.destroy');
        Route::get('/user/getDealerProductsCount', 'getDealerProductsCount')->name('user.dealer.product.getDealerProductsCount');
        Route::post('/user/update', 'update')->name('user.dealer.product.update');
    }
);

// User Cart
Route::controller(CartController::class)->group(
    function () {
        Route::get('/user/cart', 'index')->name('user.cart');
        Route::post('/user/cart/store', 'store')->name('user.cart.store');
    }
);



Route::get('/wallett', [WalletOperationController::class, 'show'])->name('user.wallets.operation');
Route::get('user/wallet_operation/data', [WalletOperationController::class, 'getDataTableUser'])->name('user.wallets.operation.data');

Route::get('/wallet_getBalance', [WalletController::class, 'getBalance'])->name('user.wallet.getBalance');

Route::controller(TransferController::class)->group(
    function () {
        Route::get('/transfer', 'show')->name('user.transfers');
        Route::get('/transfer/getDataTableUser', 'getDataTableUser')->name('user.transfers.getDataTableUser');
        Route::get('/transfer/createeee', 'create')->name('user.transfers.create');
        Route::post('/transfer/storeee', 'store')->name('user.transfers.store');
    }
);

Route::controller(TransferInformationController::class)->group(
    function () {
        Route::get('/transfer_info/getTransferInfo', 'getTransferInfo')->name('user.transfer.info.getTransferInfo');
    }
);

//Order
Route::controller(OrderController::class)->group(
    function () {
        Route::get('/orders', 'show')->name('user.order');
        Route::get('/orders/data', 'getUserDataTable')->name('user.order.data');
        Route::get('/orders/getOrdersCount', 'getOrdersCount')->name('user.order.getOrdersCount');
        Route::get('/orders/getOrders', 'getOrders')->name('user.order.getOrders');
        Route::get('/get-chart-data', 'getChartData')->name('getChartData');
    }
);

//Order Details
Route::controller(OrderDetailsController::class)->group(
    function () {
        Route::get('/order_details', 'show')->name('user.order.details');
        Route::get('/order_details/orderInfo', 'getOrderInfo')->name('user.order.details.getOrderInfo');
        Route::get('/order_details/data', 'getUserDataTable')->name('user.order.details.data');
        Route::post('/order_details/destroy', 'destroy')->name('user.order.details.destroy');

    }
);

/*Route::controller(WalletController::class)->group(
    function () {
        Route::get('/wallettt', 'show')->name('user.wallet');
        Route::get('/wallet_management/data', 'getDataTable')->name('admin.wallets.data');
    }
);*/
