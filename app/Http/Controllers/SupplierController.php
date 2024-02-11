<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSupplierRequest;
use App\Http\Requests\AddSupplierTransactionRequest;
use App\Models\Supplier;
use App\Models\SupplierTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


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

    public function getSuppliers()
    {
        $suppliers = Supplier::select('sup_id', 'name')->orderby("sup_id", "ASC")->get();
        return response()->json($suppliers);
    }

    // حساب عدد الموردين 
    public function getSuppliersCount()
    {
        $SuppliersCount = Supplier::count();
        return response()->json(['count' => $SuppliersCount]);
    }

    // احتساب المديونية
    public function getSuppliersTotalBalance(Request $request)
    {
        $timeframe = $request->input('timeframe');

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
            $startDate = null;
            $endDate = null;
        } else {
            // Handle unknown or invalid timeframe
            return response()->json(['error' => 'Invalid timeframe']);
        }

        $totalBalance = Supplier::where('balance', '>', 0)
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->sum('balance');
        return response()->json(['total_balance' => $totalBalance]);
    }

    public function getDataTable()
    {
        /* $data = Supplier::select('*');
        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $btn = '
            <a  type="button" id="ff" onclick="changeVar()" class="btn btn-info">عرض العمليات</a>
            <a href="' . Route('admin.suppliers.create',$row->id) . '" type="button" class="btn btn-info">Edit</a>
            ';
            })

            ->rawColumns(['action'])
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




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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

        /* $data['name'] =  $request->name;
        $data['email'] =  $request->email;
        $data['address'] = $request->address;
        $data['phone_number'] =  $request->phone;
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");

        Supplier::create($data);*/


        Supplier::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'address' =>  $request->address,
            'phone_number' =>  $request->phone_number,
            'balance' => 0,
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
    public function edit(Request $request)
    {
        //  $id = $request->query('id');
        // session(['myVariable' => $id]);
        $supplier = Supplier::where('sup_id', $request->query('id'))->get()->first();

        return view('Admin.Suppliers.insert_supplier', compact('supplier'));
        //return dd($supplier->sup_id);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddSupplierRequest $request)
    {
        // $supplier = Supplier::where('sup_id', $request->id)->get()->first();
        $dataToUpdate = $request->except('id');
        Supplier::where(['sup_id' => $request->id])->update($dataToUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $supplier = Supplier::where('sup_id', $request->id);
        $balance = $supplier->value('balance');

        if ($balance !== 0.0) {
            abort(400, 'فشلت العملية بسبب وجود رصيد للمورد ');
        } else {
            $supplier->delete();
        }
    }
}
