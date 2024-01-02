<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('Admin.Transfer.transfer_management');
    }


    public function getDataTable()
    {

        if (session('wallet_id') === null) {
            $model = Transfer::select('*');
        } else {
            $id = session('wallet_id');
            $model = Transfer::where('wallet_id', $id)->select('*')->get();
            session()->forget('wallet_id');
        }

        //$data = Supplier::select('*');

        return DataTables::of($model)

            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">تحديث
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
            <a  data-transfer-id="' . $row->transfer_id . '"   data-status="موافقة" class="status-change-btn dropdown-item" id="ap" href="#"><span class="badge bg-success">موافقة</span></a>
            <a data-transfer-id="' . $row->transfer_id . '"   data-status="قيد الانتظار" class="status-change-btn dropdown-item" href="#"><span class="badge bg-warning">قيد الانتظار</span></a>
            <a data-transfer-id="' . $row->transfer_id . '"  data-status="مرفوضة" class="status-change-btn dropdown-item" href="#"><span class="badge bg-danger">مرفوضة</span></a>
        </div>
                <a   data-supplier-id="' . $row->sup_id  . '" type="button" class="delete_btn btn btn-danger">حذف</a>
        
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
    public function update(Request $request)
    {
        // استخراج قيمة transfer_status من الطلب
        $dataToUpdate = $request->input('transfer_status');
    
        // تحديث السجل في قاعدة البيانات
        Transfer::where('transfer_id', $request->input('id'))->update(['transfer_status' => $dataToUpdate]);
    
        // يمكنك إضافة رسالة تأكيد أو أي شيء آخر هنا حسب الحاجة
        return response()->json(['message' => 'تم تحديث transfer_status بنجاح']);
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
