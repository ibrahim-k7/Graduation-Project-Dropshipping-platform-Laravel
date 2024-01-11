<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSupplierRequest;
<<<<<<< HEAD
use App\Models\Supplier;
=======
use App\Http\Requests\AddSupplierTransactionRequest;
use App\Models\Supplier;
use App\Models\SupplierTransaction;
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

<<<<<<< HEAD
=======

>>>>>>> fad06c427242629c39afca398ff220bb11b23866
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return  view('Admin.Suppliers.suppliers_management');
    }

<<<<<<< HEAD
    public function getDataTable()
    {
        $data = Supplier::select('*');
        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $btn = '
            <a href="' . Route('admin.suppliers.create', $row->id) . '" type="button" class="btn btn-info">Edit</a>
=======
    public function getSuppliers()
    {
        $suppliers = Supplier::select('sup_id', 'name')->orderby("sup_id", "ASC")->get();
        return response()->json($suppliers);
    }

    public function getDataTable()
    {
        /* $data = Supplier::select('*');
        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $btn = '
            <a  type="button" id="ff" onclick="changeVar()" class="btn btn-info">عرض العمليات</a>
            <a href="' . Route('admin.suppliers.create',$row->id) . '" type="button" class="btn btn-info">Edit</a>
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
            ';
            })

            ->rawColumns(['action'])
<<<<<<< HEAD
            ->make(true);
    }

=======
            ->make(true);*/

        $model = Supplier::with('SuplierTransactions');
        return DataTables::of($model)
            //عرض الرصيد الخاص بالمورد
            /*->addColumn('trens', function (Supplier $supplier) {
                $firstTransaction = $supplier->SuplierTransactions->last();
                return $firstTransaction ? $firstTransaction->balance : null;
            })*/

            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
                <a   data-supplier-id="' . $row->sup_id  . '" type="button" class="delete_btn btn btn-danger">حذف</a>
                <a href="' . route('admin.suppliers.edit', ['id' => $row->sup_id]) . '"  type="button" class="btn btn-secondary">تحديث</a>
                <a href="' . route('admin.suppliers.transactions', ['id' => $row->sup_id]) . '"   type="button" class="btn btn-primary">العمليات</a>
                </div>
    
        ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }




>>>>>>> fad06c427242629c39afca398ff220bb11b23866
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
<<<<<<< HEAD
        //
=======
>>>>>>> fad06c427242629c39afca398ff220bb11b23866

        return view('Admin.Suppliers.insert_supplier');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(AddSupplierRequest $request)
    {

<<<<<<< HEAD
=======
        /* $data['name'] =  $request->name;
        $data['email'] =  $request->email;
        $data['address'] = $request->address;
        $data['phone_number'] =  $request->phone;
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");

        Supplier::create($data);*/


>>>>>>> fad06c427242629c39afca398ff220bb11b23866
        Supplier::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'address' =>  $request->address,
<<<<<<< HEAD
            'phone_number' =>  $request->phone,
=======
            'phone_number' =>  $request->phone_number,
            'balance' => 0,
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function edit($id)
    {
        //
=======
    public function edit(Request $request)
    {
        //  $id = $request->query('id');
        // session(['myVariable' => $id]);
        $supplier = Supplier::where('sup_id', $request->query('id'))->get()->first();

        return view('Admin.Suppliers.insert_supplier', compact('supplier'));
        //return dd($supplier->sup_id);


>>>>>>> fad06c427242629c39afca398ff220bb11b23866
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function update(Request $request, $id)
    {
        //
=======
    public function update(AddSupplierRequest $request)
    {
        // $supplier = Supplier::where('sup_id', $request->id)->get()->first();
        $dataToUpdate = $request->except('id');
        Supplier::where(['sup_id' => $request->id])->update($dataToUpdate);
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function destroy($id)
    {
        //
=======
    public function destroy(Request $request)
    {
        $supplier = Supplier::where('sup_id', $request->id);
        $balance =$supplier->value('balance');

        if($balance !== 0.0){
            abort(400, 'فشلت العملية بسبب وجود رصيد للمورد ');
        }
        else{
        $supplier->delete();
        }
>>>>>>> fad06c427242629c39afca398ff220bb11b23866
    }
}
