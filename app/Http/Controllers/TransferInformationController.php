<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTransferInformationRequest;
use App\Models\TransferInformation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransferInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('Admin.Transfer.transfer_information');
    }




    public function getDataTable()
    {

        $model = TransferInformation::select('*');
        return DataTables::of($model)
            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
                <a   data-transfer_info-id="' . $row->transfer_info_id  . '" type="button" class="delete_btn btn btn-danger">حذف</a>
                <a href="' . route('admin.transfer.info.edit', ['id' => $row->transfer_info_id]) . '"  type="button" class="btn btn-secondary">تحديث</a>
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

        return view('Admin.Transfer.insert_transfer_information');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTransferInformationRequest $request)
    {
        //
        TransferInformation::create([
            'name' => $request->name,
            'phone' =>  $request->phone,
            'transfer_network' =>  $request->transfer_network,
            'created_at' => now(),
            'updated_at' => now(),
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
        //
        $transferInformation = TransferInformation::where('transfer_info_id', $request->query('id'))->get()->first();

        return view('Admin.Transfer.insert_transfer_information', compact('transferInformation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddTransferInformationRequest $request)
    {
        //
        $dataToUpdate = $request->except('id');
        TransferInformation::where(['transfer_info_id' => $request->id])->update($dataToUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $transferInformation = TransferInformation::where('transfer_info_id', $request->id);

        $transferInformation->delete();
    }
}
