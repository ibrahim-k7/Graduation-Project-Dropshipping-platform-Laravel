<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSupplierTransactionRequest;
use App\Models\Supplier;
use App\Models\SupplierTransaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SupplierTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        $id = $request->query('id');
        session(['myVariable' => $id]);
        return view('Admin.Suppliers.suppliers_transaction');
    }
    public function getDataTable()
    {
        if (session('myVariable') === null) {
            $data = SupplierTransaction::select('*');
        } else {
            $id = session('myVariable');
            $data = SupplierTransaction::where('sup_id', $id)->select('*')->get();
            session()->forget('myVariable');
        }



        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $btn = '
                    <a href="" type="button" class="btn btn-info">Edit</a>

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
        //

        $model = Supplier::select('*')->orderby("sup_id", "ASC")->get();;


        return view('Admin.Suppliers.insert_transaction', ['model' => $model]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddSupplierTransactionRequest $request)
    {
        $latestBalance = SupplierTransaction::where('sup_id', $request->sup_id)
            ->latest('created_at')
            ->value('balance');


        if ($request->transaction_type == 1) {
            // إذا كان نوع المعاملة يساوي 1
            $newBalance = $latestBalance + $request->amount;
            $request->merge(['transaction_type' => "سداد"]);
        } elseif ($request->transaction_type == 2) {
            $newBalance = $latestBalance - $request->amount;
            $request->merge(['transaction_type' => "خصم"]);
        }
        SupplierTransaction::create([
            'sup_id' => $request->sup_id,
            'transaction_type' =>  $request->transaction_type,
            'balance' =>  $newBalance,
            'amount' =>  $request->amount,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        //  dd($newBalance,$latestBalance, $request->transaction_type, $request->sup_id);

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
