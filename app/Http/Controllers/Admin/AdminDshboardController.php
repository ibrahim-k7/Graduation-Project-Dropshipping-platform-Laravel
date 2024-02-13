<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SupplierController;
use App\Models\Order;
use App\Models\Store;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDshboardController extends Controller
{
    //
    public function index()
    {
        return view('Admin.Dashboard.dashboard');
    }


    //إعادة عدد المتاجر المتوفره في قاعدة البيانات
    public function getstoreCount()
    {
        $storeCount = Store::count();
        return response()->json(['count' => $storeCount]);
    }

    public function getChartData()
    {
        // قم بحساب البيانات هنا، يمكنك استخدام أي منطقة تحسب البيانات الخاصة بك
        $data = $this->calculateChartData();

        // أرجع البيانات كـ JSON
        return response()->json($data);
    }

    private function calculateChartData()
    {
        // استرجاع البيانات من جدول الطلبات
        $orders = Order::select('created_at', 'total_amount')
            ->orderBy('created_at')
            ->get();

        $sales = Order::select('created_at', 'total_amount')
            ->where('payment_status', 'تم الدفع')
            ->orderBy('created_at')
            ->get();


        // $suppliers = Supplier::select('created_at', 'balance')
        //     ->where('balance', '>', 0)
        //     ->orderBy('created_at')
        //     ->get();


        // تحضير البيانات للـ chart
        $categories = $ordersData = [];
        $salesData = [];
        // $supCate = $suppliersDate = [];
        foreach ($orders as $order) {
            $categories[] = Carbon::parse($order->created_at)->format('Y-m-d H:i:s');
            $ordersData[] = $order->total_amount;
        }

        foreach ($sales as $sale) {
            // $categories[] = Carbon::parse($sale->created_at)->format('Y-m-d H:i:s');
            $salesData[] = $sale->total_amount;
        }

        return [
            'categories' => $categories,
            'salesData' => $salesData,
            'ordersData' => $ordersData,
        ];
    }


    public function calculateChartTrafData()
    {

        // إنشاء كائن AddWalletOperationRequest وتعيين القيم
        $request = new Request();
        $request->merge([
            'timeframe' => "all", // القيمة المطلوبة لـ wallet_id
        ]);

        // إنشاء كائن WalletOperationController واستدعاء الدالة store
        $orderController = new OrderController();
        $supplierController = new SupplierController();
        $sales = $orderController->getTotalPaidOrdersAmount($request);
        $debts =  $supplierController->getSuppliersTotalBalance($request);
        // يتم اسناد قيمة total_balance إلى المتغير debts
        $debts = $debts['total_balance'];
        $sales = $sales['total_paid_amount'];

        return [
            'sales' => $sales,
            'debts' => $debts,
        ];
    }
}
