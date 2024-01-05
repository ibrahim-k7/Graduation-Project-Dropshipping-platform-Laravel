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
                <a href="' . route('admin.wallets.operation.edit', ['id' => $row->wallet_operation_id]) . '"  type="button" class="btn btn-secondary">تحديث</a>
                <a   data-wallet_operation-id="' . $row->wallet_operation_id  . '" type="button" class="delete_btn btn btn-danger">حذف</a>
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
            $request->merge(['operation_type' => "ايداع"]);
        } elseif ($request->operation_type == 2) {
            // إذا كان نوع المعاملة هو خصم
            $newBalance = $balance - $request->amount;
            $request->merge(['operation_type' => "سحب"]);
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
    public function edit(Request $request)
    {
        //
        $walletOperation = WalletOperation::where('wallet_operation_id', $request->query('id'))->get()->first();

        return view('Admin.Wallet.insert_operation', compact('walletOperation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddWalletOperationRequest $request)
    {
        // الحصول على الـ balance الحالية
        $balance = Wallet::where('wallet_id', $request->wallet_id)->value('balance');
        $walletOperation = WalletOperation::where(['wallet_operation_id' => $request->id]);


        // في حال حصل تحديث لقيمة amount
        if ($request->amount !==  $walletOperation->value('amount')) {

            // حسب نوع المعاملة، قم بحساب القيمة الجديدة للـ balance

            // إذا كان نوع المعاملة هو سداد
            if ($request->operation_type == 1) {
                if ($request->amount > $walletOperation->value('amount')) {
                    $dfAmount = $walletOperation->value('amount') - $request->amount;
                    $newBalance = $balance - $dfAmount;
                } else {
                    $dfAmount =  $request->amount - $walletOperation->value('amount');
                    $newBalance = $balance + $dfAmount;
                }
                // إذا كان نوع المعاملة هو خصم
            } elseif ($request->operation_type == 2) {
                if ($walletOperation->value('amount') > $request->amount) {
                    $dfAmount = $walletOperation->value('amount') - $request->amount;
                    $newBalance = $balance + $dfAmount;
                } else {
                    $dfAmount =  $request->amount - $walletOperation->value('amount');
                    $newBalance = $balance - $dfAmount;
                }
            }
            // تحديث قيمة الـ balance في جدول Wallet
            Wallet::where('wallet_id', $request->wallet_id)->update(['balance' => $newBalance]);
            // تحديث قيمة الـ amount في جدول walletOperation
            $walletOperation->update(['amount' => $request->amount]);
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
        $walletOperation = WalletOperation::where('wallet_operation_id', $request->id);

        // قيمة amount و operation_type للمعاملة المراد حذفها
        $amount =  $walletOperation->value('amount');

        $operation_type = $walletOperation->value('operation_type');

        $balance = Wallet::where('wallet_id', $walletOperation->value('wallet_id'))->value('balance');
        // حساب القيمة الجديدة لـ balance بناءً على operation_type
        if ($operation_type == "ايداع") {
            $newBalance = $balance - $amount;
        } elseif ($operation_type == "سحب") {
            $newBalance = $balance + $amount;
        }

        // تحديث قيمة الـ balance في جدول Wallet
        Wallet::where('wallet_id', $walletOperation->value('wallet_id'))->update(['balance' => $newBalance]);

        // حذف بيانات المعاملة
        $walletOperation->delete();
    }
}
