<?php

namespace App\Http\Controllers;


use App\Models\Sales;
use Illuminate\Http\Request;
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
            ->get()
        ;
        return DataTables::of($data)
            ->make(true);
    }

    public function store(Request $request){

        Sales::create([
            'order_id' => $request->order_id,
            'date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
