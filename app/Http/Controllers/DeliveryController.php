<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddDeliveryRequest;
use Illuminate\Http\Request;
use App\Models\Delivery;
use Yajra\DataTables\DataTables;

class DeliveryController extends Controller
{
    public function index (){
        return view('Admin.Delivery.delivery_management');
    }



    // استدعاء البيانات
    public function getDataTable(){
        $data = Delivery::select('*');
        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
            <a href="' . Route('admin.delivery.edit', ['id' => $row->delivery_id]) . '" type="button" class="btn btn-info">Edit</a>
            <a   delivery-id="' . $row->delivery_id  . '" type="button" class="delete_btn btn btn-danger">Delete</a>
            </div>
            ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create(){
        return view('Admin.Delivery.insert_delivery');
    }


    public function store(AddDeliveryRequest $request){
        Delivery::create([
            'name' => $request->name,
            'shipping_fees' => $request->shipping_fees,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }

    // Show the form for editing the specified resource
    public function edit(Request $request){

        $delivery = Delivery::where('delivery_id',$request->query('id'))->get()->first();

        return view('Admin.Delivery.insert_delivery', compact('delivery'));

    }

    // Update the specified resource in storage.
    public function update(AddDeliveryRequest $request){
        $data= $request->except('id');
        Delivery::where(['delivery_id' => $request->id])->update($data);
    }

    // Remove the specified resource from storage.
    public function destroy(Request $request){
        Delivery::where('delivery_id', $request->id)->delete();
    }
}
