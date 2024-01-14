<?php

namespace App\Http\Controllers;

use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderDetailsController extends Controller
{
    public function index(Request $request){
        $id = $request->query('order_id');
        session(['myVariable' => $id]);
        return view('Admin.Order.order_details_management');
    }

    // استدعاء البيانات
    public function getDataTable(Request $request){
        if (session('myVariable') === null) {
            $data = OrderDetails::select('order details.order_details_id','orders.order_id','products.name','products.description',
                'order details.quantity','order details.total_cost','order details.sub_weight')
                ->join('products','products.id','=','order details.pro_id')
                ->join('orders','orders.order_id','=','order details.order_id')
//                ->where('orders.order_id', $request->query('order_id'))
                ->get();
        } else {
            $id = session('myVariable');
            $data = OrderDetails::select('order details.order_details_id','orders.order_id','products.name','products.description',
                'order details.quantity','order details.total_cost','order details.sub_weight')
                ->join('products','products.id','=','order details.pro_id')
                ->join('orders','orders.order_id','=','order details.order_id')
                ->where('orders.order_id',$id)
                ->get();
            session()->forget('myVariable');
        }


        return DataTables::of($data)
            ->make(true);
    }
}
