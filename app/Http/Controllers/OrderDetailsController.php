<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOrderDetailsRequest;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderDetailsController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->query('order_id');
        session(['myVariable' => $id]);
        return view('Admin.Order.order_details_management');
    }

    public function addProduct(Request $request)
    {
        // return dd($request->order_id);

        // OrderDetails::create([
        //     'order_id ' => $request->order_id,
        //     'pro_id ' =>  $request->product['id'] ,
        //     'quantity' =>  $request->quantity,
        //     'total_cost' =>  $request->$request->product['selling_price']*$request->quantity,
        //     'sub_weight' =>  $request->$request->product['weight']*$request->quantity,
        // ]);

        if (isset($request->product) && !empty($request->product)) {
            OrderDetails::create([
                'order_id' => $request->order_id,
                'pro_id' =>  $request->product['id'],
                'quantity' =>  $request->quantity,
                'total_cost' =>  $request->product['selling_price'] * $request->quantity,
                'sub_weight' =>  $request->product['weight'] * $request->quantity,
            ]);

            $order = Order::where('order_id', $request->order_id)->first();
            $total_amount = $order->total_amount;
            $total_amount = $total_amount + $request->product['selling_price'] * $request->quantity;

            $total_per_shp = $order->total_per_shp +  $request->product['selling_price'] * $request->quantity;

            $total_Weight = $order->total_weight;
            $total_Weight = $total_Weight + $request->product['weight'] * $request->quantity;

            Order::where('order_id', $request->order_id)->update([
                'total_weight' => $total_Weight,
                'total_amount' => $total_amount,
                'total_per_shp' => $total_per_shp,
            ]);
        } else {
            // يمكنك إضافة رمز خطأ أو رسالة تنبيه هنا إذا لزم الأمر
        }
    }

    public function getOrderInfo(Request $request)
    {
        // return dd($request->id);
        $order = Order::where('order_id', $request->id)->join('delivery', 'delivery.delivery_id', '=', 'orders.delivery_id')
            ->first();
        return response()->json($order);
    }

    // new function
    public function show(Request $request)
    {
        $id = $request->query('id');
        session(['order_id' => $id]);
        // عرض البيانات في العرض
        return view('User.Order.order_details');
    }
    // استدعاء البيانات
    public function getDataTable()
    {
        if (session('myVariable') === null) {
            $data = OrderDetails::select(
                'order details.order_details_id',
                'orders.order_id',
                'products.name',
                'products.description',
                'order details.quantity',
                'order details.total_cost',
                'order details.sub_weight'
            )
                ->join('products', 'products.id', '=', 'order details.pro_id')
                ->join('orders', 'orders.order_id', '=', 'order details.order_id')
                ->get();
        } else {
            $id = session('myVariable');
            $data = OrderDetails::select(
                'order details.order_details_id',
                'orders.order_id',
                'products.name',
                'products.description',
                'order details.quantity',
                'order details.total_cost',
                'order details.sub_weight'
            )
                ->join('products', 'products.id', '=', 'order details.pro_id')
                ->join('orders', 'orders.order_id', '=', 'order details.order_id')
                ->where('orders.order_id', $id)
                ->get();
            session()->forget('myVariable');
        }


        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $btn = '
                <div class="btn-group" role="group">
                <a href="' . Route('admin.order.details.return', ['id' => $row->order_details_id]) . '" type="button" class="btn btn-secondary">استرجاع المنتج</a>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // استدعاء البيانات لوجهه المستخدم
    public function getUserDataTable()
    {

        // $id = $request->id;
        $id = session('order_id');

        $data = OrderDetails::select(
            'order details.order_details_id',
            'orders.order_id',
            'products.id',
            'products.selling_price',
            'products.weight',
            'products.name',
            'products.image',
            'products.description',
            'order details.quantity',
            'order details.total_cost',
            'order details.sub_weight'
        )
            ->join('products', 'products.id', '=', 'order details.pro_id')
            ->join('orders', 'orders.order_id', '=', 'order details.order_id')
            ->where('orders.order_id', $id)
            ->get();
        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $btn = '
                <div class="btn-group" role="group">
                <a   data-order_details_id="' . $row->order_details_id  . '" type="button" class="delete_btn btn btn-danger">حذف</a>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);

            session()->forget('order_id');

    }


    // Show the form to return the specified order
    public function return(Request $request)
    {

        $product = OrderDetails::where('order_details_id', $request->query('id'))->get()->first();

        return view('Admin.Order.return_order', compact('product'));
    }

    // Update the specified order in storage.
    public function update(AddOrderDetailsRequest $request)
    {

        OrderDetails::where(['order_details_id' => $request->order_details_id])
            ->update(['quantity' => $request->quantity, 'total_cost' => $request->total_cost]);
    }

    public function destroy(Request $request)
    {
        //
        $orderDetails = OrderDetails::where('order_details_id', $request->id)->first();
        $order = Order::where('order_id', $orderDetails->order_id)->first();

        $total_amount = $order->total_amount;
        $total_amount = $total_amount - $orderDetails->total_cost;

        $total_per_shp = $order->total_per_shp - $orderDetails->total_cost;

        $total_Weight = $order->total_weight;
        $total_Weight = $total_Weight - $orderDetails->sub_weight;

        Order::where('order_id', $orderDetails->order_id) ->update([
            'total_weight' => $total_Weight,
            'total_amount' => $total_amount,
            'total_per_shp' => $total_per_shp,
        ]);
        OrderDetails::where('order_details_id', $request->id)->delete();
    }
}
