<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddWalletOperationRequest;
use App\Models\Wallet;
use App\Models\WalletOperation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WalletOperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $wallet_id = $request->query('id');
        session(['wallet_id' => $wallet_id]);

        return view('Admin.Wallet.wallet_operation');
    }


    public function getDataTable()
    {

        if (session('wallet_id') === null) {
            $model = WalletOperation::select('*');
        } else {
            $id = session('wallet_id');
            $model = WalletOperation::where('wallet_id', $id)->select('*')->get();
            session()->forget('wallet_id');
        }

        //$data = Supplier::select('*');
        
        return DataTables::of($model)

            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
                <a href="' . route('admin.supplier.edit', ['id' => $row->sup_id]) . '"  type="button" class="btn btn-secondary">تحديث</a>
                <a   data-supplier-id="' . $row->sup_id  . '" type="button" class="delete_btn btn btn-danger">حذف</a>
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
        return view('Admin.Wallet.insert_operation');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddWalletOperationRequest $request)
    {
        //
        // الحصول على الـ balance الحالية
        $balance = Wallet::where('wallet_id', $request->wallet_id)->value('balance');

        // حسب نوع المعاملة، قم بحساب القيمة الجديدة للـ balance
        if ($request->operation_type == 1) {
            // إذا كان نوع المعاملة هو ايداع
            $newBalance = $balance + $request->amount;
            $request->merge(['operation_type' => "سداد"]);
        } elseif ($request->operation_type == 2) {
            // إذا كان نوع المعاملة هو خصم
            $newBalance = $balance - $request->amount;
            $request->merge(['operation_type' => "خصم"]);
        }

        // إنشاء سجل في جدول WalletOperation
        WalletOperation::create([
            'wallet_id' => $request->wallet_id,
            'operation_type' =>  $request->operation_type,
            'amount' =>  $request->amount,
            'balance_aft_transfer' => $newBalance,
            'details' => $request->details,
        ]);

        // تحديث قيمة الـ balance في جدول Wallet
        Wallet::where('wallet_id', $request->wallet_id)->update(['balance' => $newBalance]);
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
