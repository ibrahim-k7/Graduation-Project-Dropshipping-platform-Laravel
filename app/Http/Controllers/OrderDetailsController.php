<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOrderDetailsRequest;
use App\Models\Delivery;
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

    // new function
    public function show(){
        return view('User.Order.order_details');
    }
    // استدعاء البيانات
    public function getDataTable(){
        if (session('myVariable') === null) {
            $data = OrderDetails::select('order details.order_details_id','orders.order_id','products.name','products.description',
                'order details.quantity','order details.total_cost','order details.sub_weight')
                ->join('products','products.id','=','order details.pro_id')
                ->join('orders','orders.order_id','=','order details.order_id')
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


        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action',function ($row){
                return $btn = '
                <div class="btn-group" role="group">
                <a href="' . Route('admin.order.details.return', ['id' => $row->order_details_id]) . '" type="button" class="btn btn-secondary">استرجاع المنتج</a>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Show the form to return the specified order
    public function return(Request $request){

        $product = OrderDetails::where('order_details_id',$request->query('id'))->get()->first();

        return view('Admin.Order.return_order', compact('product'));

    }

    // Update the specified order in storage.
    public function update(AddOrderDetailsRequest $request){

        OrderDetails::where(['order_details_id' => $request->order_details_id])
            ->update(['quantity'=>$request->quantity, 'total_cost'=>$request->total_cost]);
    }
}
