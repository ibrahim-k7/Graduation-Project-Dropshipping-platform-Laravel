<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('Admin.Wallet.wallet_management');
    }

    public function getWallets()
    {
        $wallet = Wallet::with('store')->get();

        return response()->json($wallet);
    }



    public function getDataTable()
    {
        $data = Wallet::select('*');
        $model = Wallet::with('store');
        return DataTables::of($model)
            //عرض الرصيد الخاص بالمورد
            ->addColumn('storeName', function (Wallet $wallet) {
                return $result = $wallet->store->store_name;
            })

            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
                <a href="' . route('admin.wallets.operation', ['id' => $row->wallet_id]) . '"  id="showOperationsBtn" type="button" class="btn btn-primary">العمليات</a>
                <a href="' . route('admin.suppliers.transaction', ['id' => $row->wallet_id]) . '"  id="showOperationsBtn" type="button" class="btn btn-primary">الحوالات</a>
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
