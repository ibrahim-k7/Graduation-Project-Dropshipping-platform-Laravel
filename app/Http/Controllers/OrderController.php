<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(){
        return view('Admin.Order.order_management');
    }

    // استدعاء البيانات
    public function getDataTable(){
        $data = Order::select('orders.order_id','store.store_name','delivery.name','orders.platform',
            'orders.payment_status','orders.customer_name','orders.customer_phone','orders.customer_email',
            'orders.shipping_address','orders.order_status','orders.total_per_shp','orders.total_weight',
            'orders.total_amount','orders.created_at','orders.updated_at')
            ->join('store','store.store_id','=','orders.store_id')
            ->join('delivery','delivery.delivery_id','=','orders.delivery_id')->get();

        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action',function ($row) {
                return $btn = '
            <a href="' . Route('admin.order.details',['order_id' => $row->order_id]) . '" type="button" class="btn btn-primary">التفاصيل</a>
            <a href="' . Route('admin.order.details',['order_id'=> $row->order_id]) . '" type="button" class="btn btn-secondary">تحديث حالة الدفع</a>
            <a href="' . Route('admin.order.details',['order_id'=> $row->order_id]) . '" type="button" class="btn btn-secondary">تحديث حالة الطلب</a>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


}
