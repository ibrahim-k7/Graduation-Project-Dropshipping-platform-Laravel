<?php

namespace App\Http\Controllers;


use App\Models\Sales;
use Yajra\DataTables\DataTables;

class SalesController extends Controller
{
    public function index (){
        return view('Admin.Order.sales_management');
    }

    public function getDataTable () {
        $data = Sales::select('sales.sales_id', 'sales.order_id', 'orders.platform','orders.total_amount',
        'sales.date')
            ->join('orders','sales.order_id','=','orders.order_id')
            ->where('orders.order_status','تم التوصيل')
            ->get()
        ;
        return DataTables::of($data)
            ->make(true);
    }
}
