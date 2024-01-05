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
            $data = SupplierTransaction::with('supplier');
        } else {
            $id = session('myVariable');
            $data = SupplierTransaction::where('sup_id', $id)->select('*')->get();
            session()->forget('myVariable');
        }



        return DataTables::of($data)->addIndexColumn()
            ->addColumn('supplier', function (SupplierTransaction $supplierTransaction) {
                return $result = $supplierTransaction->supplier->name;
            })
            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
                <a href="' . route('admin.suppliers.transactions.edit', ['id' => $row->transaction_id]) . '"  type="button" class="btn btn-secondary">تحديث</a>
                <a   id="delete_btn" data-transaction-id="' . $row->transaction_id  . '" type="button" class="delete_btn btn btn-danger">حذف</a>
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
        //
         return view('Admin.Suppliers.insert_transaction');
      /*  $data = SupplierTransaction::with('supplier')->where('transaction_id', 25)->get();
                $supplier =$data[0]->supplier->value('name');
                
                return dd($supplier);*/
            
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddSupplierTransactionRequest $request)
    {
        // الحصول على الـ balance الحالية
        $balance = Supplier::where('sup_id', $request->sup_id)->value('balance');

        // حسب نوع المعاملة، قم بحساب القيمة الجديدة للـ balance
        if ($request->transaction_type == 1) {
            // إذا كان نوع المعاملة هو سداد
            $newBalance = $balance + $request->amount;
            $request->merge(['transaction_type' => "سداد"]);
        } elseif ($request->transaction_type == 2) {
            // إذا كان نوع المعاملة هو خصم
            $newBalance = $balance - $request->amount;
            $request->merge(['transaction_type' => "خصم"]);
        }

        // إنشاء سجل في جدول SupplierTransaction
        SupplierTransaction::create([
            'sup_id' => $request->sup_id,
            'transaction_type' =>  $request->transaction_type,
            'amount' =>  $request->amount,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // تحديث قيمة الـ balance في جدول Supplier
        Supplier::where('sup_id', $request->sup_id)->update(['balance' => $newBalance]);
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
        $supplierTransaction = SupplierTransaction::where('transaction_id', $request->query('id'))->get()->first();

        //return dd($supplierTransaction);
        return view('Admin.Suppliers.insert_transaction', compact('supplierTransaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // والله في غلط ف الحسابات سوو نفسكم ما تشوفو الى ان ربك يفرجها
    public function update(AddSupplierTransactionRequest $request)
    {
        // الحصول على الـ balance الحالية
        $balance = Supplier::where('sup_id', $request->sup_id)->value('balance');
        $supplierTransaction = SupplierTransaction::where(['transaction_id' => $request->id]);

        //$dfAmount = abs($request->amount -  $supplierTransaction->value('amount'));

        // في حال حصل تحديث لقيمة amount
        if ($request->amount !==  $supplierTransaction->value('amount')) {

            // حسب نوع المعاملة، قم بحساب القيمة الجديدة للـ balance

            // إذا كان نوع المعاملة هو سداد
            if ($request->transaction_type == 1) {
                if ($request->amount > $supplierTransaction->value('amount')) {
                    $dfAmount = $supplierTransaction->value('amount') - $request->amount;
                    $newBalance = $balance - $dfAmount;
                } else {
                    $dfAmount =  $request->amount - $supplierTransaction->value('amount');
                    $newBalance = $balance + $dfAmount;
                }
                // إذا كان نوع المعاملة هو خصم
            } elseif ($request->transaction_type == 2) {
                if ($supplierTransaction->value('amount') > $request->amount) {
                    $dfAmount = $supplierTransaction->value('amount') - $request->amount;
                    $newBalance = $balance + $dfAmount;
                } else {
                    $dfAmount =  $request->amount - $supplierTransaction->value('amount');
                    $newBalance = $balance - $dfAmount;
                }

                //  $newBalance = $balance - $request->amount;
            }
            // تحديث قيمة الـ balance في جدول Supplier
            Supplier::where('sup_id', $request->sup_id)->update(['balance' => $newBalance]);
            // تحديث قيمة الـ amount في جدول SupplierTransaction
            $supplierTransaction->update(['amount' => $request->amount]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // الحصول على بيانات المعاملة التي ستُحذف
        $transaction = SupplierTransaction::where('transaction_id', $request->id);

        // قيمة amount و transaction_type للمعاملة المراد حذفها
        $amount =  $transaction->value('amount');

        $transactionType = $transaction->value('transaction_type');

        $balance = Supplier::where('sup_id', $transaction->value('sup_id'))->value('balance');
        // حساب القيمة الجديدة لـ balance بناءً على transaction_type
        if ($transactionType == "سداد") {
            $newBalance = $balance - $amount;
        } elseif ($transactionType == "خصم") {
            $newBalance = $balance + $amount;
        }

        // تحديث قيمة الـ balance في جدول Supplier
        Supplier::where('sup_id', $transaction->value('sup_id'))->update(['balance' => $newBalance]);

        // حذف بيانات المعاملة
        $transaction->delete();
    }
}
