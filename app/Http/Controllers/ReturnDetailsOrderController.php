<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOrderDetailsRequest;
use App\Http\Requests\ReturnOrderRequest;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\ReturnDetailsOrder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReturnDetailsOrderController extends Controller
{
    public function index(){

        return view('Admin.Order.Returned_order_details_management');
    }

    // استدعاء البيانات
    public function getDataTable(){
        $data = ReturnDetailsOrder::select('return details order.return_id','order details.order_details_id','order details.order_id',
            'products.name', 'products.description','return details order.return_date','return details order.quantity_returned',
            'return details order.amount_returned')
            ->join('order details','order details.order_details_id','=','return details order.order_details_id')
            ->join('products','products.id','=','order details.pro_id')
            ->get();

        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action',function ($row){
                return $btn = '
                <div class="btn-group" role="group">
                <a href="' . Route('admin.returned.order.details.edit', ['return_id' => $row->return_id]) . '" type="button"
                class="btn btn-secondary">تعديل</a>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // insert the returned order in storage
    public function store(ReturnOrderRequest $request){

        // الحصول على كمية واجمالي المنتج في الطلب
        $quantity = OrderDetails::where('order_details_id',$request->order_details_id)->value('quantity') ;
        $total_cost = OrderDetails::where('order_details_id',$request->order_details_id)->value('total_cost') ;

        // التحقق من كمية واجمالي المنتج في الطلب
        if ($quantity >= $request->quantity_returned && $total_cost >= $request->amount_returned){
            ReturnDetailsOrder::create([
                'order_details_id' => $request->order_details_id,
                'quantity_returned' => $request->quantity_returned,
                'amount_returned' => $request->amount_returned,
                'return_date' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);

            $new_quantity = $quantity - $request->quantity_returned;
            $new_total_cost = $total_cost - $request->amount_returned;

            // إنشاء كائن AddOrderDetailsRequest وتعيين القيم
            $addOrderDetailsRequest = new AddOrderDetailsRequest();
            $addOrderDetailsRequest->merge([
                'order_details_id' => $request->order_details_id,
                'quantity' => $new_quantity,
                'total_cost' => $new_total_cost,
            ]);

            // إنشاء كائن OrderDetailsController واستدعاء الدالة update
            $orderDetailsController = new OrderDetailsController();
            $orderDetailsController->update($addOrderDetailsRequest);
        }else{
            abort(400, 'الكمية أو اجمالي المنتج أقل من المسترجع');
        }

    }

    // Show the form to edit the specified returned order
    public function edit(Request $request){

        $returned_product = ReturnDetailsOrder::where('return_id',$request->query('return_id'))->get()->first();
        $order_details = OrderDetails::where('order_details_id', $returned_product->order_details_id)->get()->first();
        $product = Product::where('id',$order_details->pro_id)->get()->first() ;
        return view('Admin.Order.return_order', compact('returned_product','product'));

    }

    // Update the specified order in storage.
    public function update(ReturnOrderRequest $request){

        // الحصول على كمية واجمالي المنتج في الطلب
        $quantity = OrderDetails::where('order_details_id',$request->order_details_id)->value('quantity') ;
        $total_cost = OrderDetails::where('order_details_id',$request->order_details_id)->value('total_cost') ;

        if ($quantity >= $request->quantity_returned && $total_cost >= $request->amount_returned){

            ReturnDetailsOrder::where(['return_id' => $request->return_id])
                ->update(['quantity_returned' => $request->quantity_returned, 'amount_returned' => $request->amount_returned ]);

            $new_quantity = $quantity - $request->quantity_returned;
            $new_total_cost = $total_cost - $request->amount_returned;

            // إنشاء كائن AddOrderDetailsRequest وتعيين القيم
            $addOrderDetailsRequest = new AddOrderDetailsRequest();
            $addOrderDetailsRequest->merge([
                'order_details_id' => $request->order_details_id,
                'quantity' => $new_quantity,
                'total_cost' => $new_total_cost,
            ]);

            // إنشاء كائن OrderDetailsController واستدعاء الدالة update
            $orderDetailsController = new OrderDetailsController();
            $orderDetailsController->update($addOrderDetailsRequest);
        }else{
            abort(400, 'الكمية أو اجمالي المنتج أقل من المسترجع');
        }




//        $data= $request->except('return_id');
//        ReturnDetailsOrder::where(['return_id' => $request->return_id])->update($data);
    }
}
