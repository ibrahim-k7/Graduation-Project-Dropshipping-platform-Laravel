<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddWalletOperationRequest;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {

        return view('Admin.Order.order_management');
    }

    public function getOrders()
    {

        $data = Order::select(
            'orders.order_id',
            'store.store_name',
            'delivery.name',
            'orders.platform',
            'orders.payment_status',
            'orders.customer_name',
            'orders.customer_phone',
            'orders.customer_email',
            'orders.shipping_address',
            'orders.order_status',
            'orders.total_per_shp',
            'orders.total_weight',
            'orders.total_amount',
            'orders.created_at',
            'orders.updated_at',
            'wallet.wallet_id'
        )
            ->join('store', 'store.store_id', '=', 'orders.store_id')
            ->join('wallet', 'wallet.store_id', '=', 'orders.store_id')
            ->join('delivery', 'delivery.delivery_id', '=', 'orders.delivery_id')
            ->get();

        return response()->json($data);
    }

    //إرجاع عدد الطلبات 
    public function getOrdersCount(Request $request)
    {
        $timeframe = $request->input('timeframe');

        if ($timeframe == 'thisMonth') {
            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($timeframe == 'thisYear') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } elseif ($timeframe == 'today') {
            $startDate = Carbon::now()->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        } elseif ($timeframe == 'all') {
            $ordersCount = Order::count();
            return response()->json(['count' => $ordersCount]);
        } else {
            // Handle unknown or invalid timeframe
            return response()->json(['error' => 'Invalid timeframe']);
        }
        $ordersCount = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        return response()->json(['count' => $ordersCount]);
    }

    // ارجاع إجمالي المبيعات
    public function getTotalPaidOrdersAmount(Request $request)
    {
        $timeframe = $request->input('timeframe');

        if ($timeframe == 'thisMonth') {
            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth(); // تم تعديلها هنا لتكون قبل شهر من الوقت الحالي
        } elseif ($timeframe == 'thisYear') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } elseif ($timeframe == 'today') {
            $startDate = Carbon::now()->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        } elseif ($timeframe == 'all') {
            $startDate = null;
            $endDate = null;
        } else {
            // Handle unknown or invalid timeframe
            return response()->json(['error' => 'Invalid timeframe']);
        }

        $totalAmount = Order::where('payment_status', 'تم الدفع')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->sum('total_per_shp');

        return response()->json(['total_paid_amount' => $totalAmount]);
        // $totalAmount = Order::where('payment_status', 'تم الدفع')->sum('total_per_shp');
        // return response()->json(['total_paid_amount' => $totalAmount]);
    }


    // استدعاء البيانات
    public function getDataTable()
    {

        $data = Order::select(
            'orders.order_id',
            'store.store_name',
            'delivery.name',
            'orders.platform',
            'orders.payment_status',
            'orders.customer_name',
            'orders.customer_phone',
            'orders.customer_email',
            'orders.shipping_address',
            'orders.order_status',
            'orders.total_per_shp',
            'orders.total_weight',
            'orders.total_amount',
            'orders.created_at',
            'orders.updated_at',
            'wallet.wallet_id'
        )
            ->join('store', 'store.store_id', '=', 'orders.store_id')
            ->join('wallet', 'wallet.store_id', '=', 'orders.store_id')
            ->join('delivery', 'delivery.delivery_id', '=', 'orders.delivery_id')
            ->get();

        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $isDisabled = $row->order_status === 'تم التوصيل' ? 'disabled' : '';

                return $btn = '
                <div class="btn-group" role="group">
                    <!--             delete order button             -->
                    <a data-order-id="' . $row->order_id . '"
                       data-order_status="' . $row->order_status . '"
                       type="button"
                       class="delete_btn btn btn-danger">
                       حذف
                    </a>
                    <!--             payment status update             -->
                    <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ' . $isDisabled . '>
                    تحديث الدفع
                    <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">

                        <a data-order-id="' . $row->order_id . '"
                           data-wallet_id="' . $row->wallet_id . '"
                           data-total_amount="' . $row->total_amount . '"
                           data-payment_status="تم الدفع"
                           class="payment-status-change-btn dropdown-item"
                           id="ap"
                           href="#">
                           <span class="badge bg-success">تم الدفع</span>
                        </a>
                        <a data-order-id="' . $row->order_id . '"
                           data-payment_status="لم يتم الدفع"
                           class="payment-status-change-btn dropdown-item"
                           href="#">
                           <span class="badge bg-warning">لم يتم الدفع</span>
                        </a>
                        <a data-order-id="' . $row->order_id . '"
                           data-wallet_id="' . $row->wallet_id . '"
                           data-total_amount="' . $row->total_amount . '"
                           data-payment_status="تم الغاء الدفع"
                           class="payment-status-change-btn dropdown-item"
                           href="#">
                           <span class="badge bg-danger">تم الغاء الدفع</span>
                        </a>
                    </div>

                    <!--             order status update             -->
                    <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ' . $isDisabled . '>
                    تحديث الطلب
                    <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        <a data-order-id="' . $row->order_id . '"
                           data-order_status="تم التوصيل"
                           data-wallet_id="' . $row->wallet_id . '"
                           data-total_amount="' . $row->total_amount . '"
                           data-payment_status="تم الدفع"
                           class="order-status-change-btn dropdown-item"
                           id="ap2"
                           href="#">
                           <span class="badge bg-success">تم التوصيل</span>
                        </a>
                        <a data-order-id="' . $row->order_id . '"
                           data-order_status="يتم توصيل الطلب"
                           class="order-status-change-btn dropdown-item"
                           href="#">
                           <span class="badge bg-warning">يتم توصيل الطلب</span>
                        </a>
                        <a data-order-id="' . $row->order_id . '"
                           data-order_status="تم الغاء الطلب"
                           data-wallet_id="' . $row->wallet_id . '"
                           data-total_amount="' . $row->total_amount . '"
                           data-payment_status="تم الغاء الدفع"
                           class="order-status-change-btn dropdown-item"
                           href="#">
                           <span class="badge bg-danger">تم الغاء الطلب</span>
                        </a>
                    </div>
                    <a href="' . Route('admin.order.details', ['order_id' => $row->order_id]) . '" type="button" class="btn btn-primary">التفاصيل</a>

                <div/>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function updatePaymentStatus(Request $request)
    {
        // استخراج قيمة payment_status من الطلب
        $payment_status = $request->input('payment_status');

        if ($payment_status == "تم الدفع") {
            // إنشاء كائن AddWalletOperationRequest وتعيين القيم
            $addWalletOperationRequest = new AddWalletOperationRequest();
            $addWalletOperationRequest->merge([
                'wallet_id' => $request->wallet_id, // القيمة المطلوبة لـ wallet_id
                'operation_type' => 2, // القيمة المطلوبة لـ operation_type
                'amount' => $request->total_amount, // القيمة المطلوبة لـ amount
                'details' => ' خصم مقابل الطلب بمعرف ' . $request->id, // القيمة المطلوبة لـ details
            ]);

            // إنشاء كائن WalletOperationController واستدعاء الدالة store
            $walletOperationController = new WalletOperationController();
            $walletOperationController->store($addWalletOperationRequest);
        } elseif ($payment_status == "تم الغاء الدفع") {
            // إنشاء كائن AddWalletOperationRequest وتعيين القيم
            $addWalletOperationRequest = new AddWalletOperationRequest();
            $addWalletOperationRequest->merge([
                'wallet_id' => $request->wallet_id, // القيمة المطلوبة لـ wallet_id
                'operation_type' => 1, // القيمة المطلوبة لـ operation_type
                'amount' => $request->total_amount, // القيمة المطلوبة لـ amount
                'details' => ' ايداع مقابل الغاء الطلب بمعرف ' . $request->id, // القيمة المطلوبة لـ details
            ]);

            // إنشاء كائن WalletOperationController واستدعاء الدالة store
            $walletOperationController = new WalletOperationController();
            $walletOperationController->store($addWalletOperationRequest);
        }

        // تحديث السجل في قاعدة البيانات
        Order::where('order_id', $request->input('id'))->update(['payment_status' => $payment_status]);

        // يمكنك إضافة رسالة تأكيد أو أي شيء آخر هنا حسب الحاجة
        return response()->json(['message' => 'تم تحديث paymnet_status بنجاح']);
    }

    public function updateOrderStatus(Request $request)
    {
        // استخراج قيمة order_status من الطلب
        $order_status = $request->input('order_status');

        // تحديث السجل في قاعدة البيانات
        Order::where('order_id', $request->input('id'))->update(['order_status' => $order_status]);

        // يمكنك إضافة رسالة تأكيد أو أي شيء آخر هنا حسب الحاجة
        return response()->json(['message' => 'تم تحديث order_status بنجاح']);
    }

    public function destroy(Request $request)
    {
        if ($request->order_status == "تم التوصيل") {
            abort(400, 'لا يمكن حذف طلب تم توصيله');
        }

        $order = Order::where('order_id', $request->id);

        $order->delete();
    }
}
