<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddWalletOperationRequest;
use App\Http\Requests\UpdateCustomerInfoRequest;
use App\Models\Order;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {

        return view('Admin.Order.order_management');
    }

    public function show()
    {
        return view('user.Order.order');
    }

    //[جلب حاله الدفع من خلال معرف الطلب]
    public function getPaymentStatusById($id){
        $data = Order::where('order_id', $id)->select('payment_status')->first();
        return $data;
    }

    public function getWalletId(Request $request)
    {
        $store_id = $request->store_id;
        $data = Wallet::where('store_id', $store_id)->select('wallet_id')->first();
        return response()->json($data);
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
        // استخراج store_id من المستخدم المسجل الحالي
        $store_id = Auth::user()->store_id;
        $orders = Order::select('created_at', 'total_amount')
            ->where('store_id', $store_id)
            ->where('payment_status', 'تم الدفع')
            ->orderBy('created_at')
            ->get();

        // تحضير البيانات للـ chart
        $categories = $salesData = [];

        foreach ($orders as $order) {
            $categories[] = Carbon::parse($order->created_at)->format('Y-m-d H:i:s');
            $salesData[] = $order->total_amount;
        }

        return [
            'categories' => $categories,
            'salesData' => $salesData,
        ];
    }

    public function getOrders(Request $request)
    {
        $store_id = $request->input('store_id');
        if ($request->has('store_id')) {
            $data = Order::select('*')
                ->join('store', 'store.store_id', '=', 'orders.store_id')
                ->join('wallet', 'wallet.store_id', '=', 'orders.store_id')
                ->join('delivery', 'delivery.delivery_id', '=', 'orders.delivery_id')
                ->where('store.store_id', $store_id)
                ->get();
        } else {
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
        }

        return response()->json($data);
    }

    //إرجاع عدد الطلبات
    public function getOrdersCount(Request $request)
    {
        $timeframe = $request->input('timeframe');
        $store_id = $request->input('store_id');

        // التحقق مما إذا كانت store_id موجودة في الطلب
        if ($request->has('store_id')) {
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
                $ordersCount = Order::where('store_id', $store_id)->count();
                return response()->json(['count' => $ordersCount]);
            } else {
                // Handle unknown or invalid timeframe
                return response()->json(['error' => 'Invalid timeframe']);
            }
            // استخدام store_id في الاستعلام
            $ordersCount = Order::where('store_id', $store_id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
        } else {
            // لا يوجد store_id في الطلب، قم بالعمل بشكل افتراضي
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

        return ['total_paid_amount' => $totalAmount];
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
            'wallet.wallet_id',
        )
            ->join('store', 'store.store_id', '=', 'orders.store_id')
            ->join('wallet', 'wallet.store_id', '=', 'orders.store_id')
            ->join('delivery', 'delivery.delivery_id', '=', 'orders.delivery_id')
            ->get();

        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $isDisabled = $row->order_status === 'تم التوصيل' ? 'disabled' : '';
                $isDisabled2 = $row->payment_status === 'تم الدفع' ? 'disabled' : '';

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
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ' . $isDisabled2 . '>
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
                           class="order-status-change-btn dropdown-item"
                           href="#">
                           <span class="badge bg-danger">تم الغاء الطلب</span>
                        </a>
                    </div>
                    <!--  تم هنا تعديل -->
                    <a href="' . Route('admin.order.details', ['order_id' => $row->order_id]) . '" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </a>
                <div/>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // استدعاء البيانات لوجهه المستخدم
    public function getUserDataTable()
    {

        // استخراج store_id من المستخدم المسجل الحالي
        $store_id = Auth::user()->store_id;
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
            'wallet.wallet_id',
        )
            ->join('store', 'store.store_id', '=', 'orders.store_id')
            ->join('wallet', 'wallet.store_id', '=', 'orders.store_id')
            ->join('delivery', 'delivery.delivery_id', '=', 'orders.delivery_id')
//            ->where('orders.store_id',$store_id)
            ->get();

        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $isDisabled = $row->order_status === 'تم التوصيل' ? 'disabled' : '';
                $isDisabled2 = $row->payment_status === 'تم الدفع' ? 'disabled' : '';

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
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ' . $isDisabled2 . '>
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
                        <!--  تم هنا تعديل -->
                        <a href="' . Route('user.order.details', ['id' => $row->order_id]) . '" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                            </svg>
                        </a>
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
                'details' => ' خصم مقابل الطلب بمعرف ' . $request->order_id, // القيمة المطلوبة لـ details
            ]);
            // إنشاء كائن WalletOperationController واستدعاء الدالة store
            $walletOperationController = new WalletOperationController();
            $walletOperationController->store($addWalletOperationRequest);

            //انشاء كائن من SalesController واستدعاء دالة store
            $salesController = new SalesController();
            $salesController->store($request);
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
        Order::where('order_id', $request->input('order_id'))->update(['payment_status' => $payment_status]);

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

    public function updateCustomerInfo(UpdateCustomerInfoRequest $request)
    {

        // return dd($request);
        Order::where('order_id', $request->id)->update([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'shipping_address' => $request->shipping_address,
        ]);

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
