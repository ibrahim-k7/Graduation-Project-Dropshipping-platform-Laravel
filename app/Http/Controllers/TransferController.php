<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\WalletOperationController;
use App\Http\Requests\AddWalletOperationRequest;


class TransferController extends Controller
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
                $isDisabled = $row->transfer_status === 'موافقة' ? 'disabled' : '';

                return '
            <div class="btn-group" role="group">
            <a data-transfer-id="' . $row->transfer_id . '"
            data-transfer_status="' . $row->transfer_status . '" 
                type="button" 
                class="delete_btn btn btn-danger">
                حذف
            </a>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" 
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ' . $isDisabled . '>
                    تحديث
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a data-transfer-id="' . $row->transfer_id . '"  
                        data-wallet_id="' . $row->wallet_id . '"  
                        data-transfer_number="' . $row->transfer_number . '" 
                        data-amount_transferred="' . $row->amount_transferred . '"   
                        data-status="موافقة" 
                        class="status-change-btn dropdown-item" 
                        id="ap" 
                        href="#">
                        <span class="badge bg-success">موافقة</span>
                    </a>
                    <a data-transfer-id="' . $row->transfer_id . '"  
                        data-status="قيد الانتظار" 
                        class="status-change-btn dropdown-item" 
                        href="#">
                        <span class="badge bg-warning">قيد الانتظار</span>
                    </a>
                    <a data-transfer-id="' . $row->transfer_id . '"  
                        data-status="مرفوضة" 
                        class="status-change-btn dropdown-item" 
                        href="#">
                        <span class="badge bg-danger">مرفوضة</span>
                    </a>
                </div>
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
        return view('User.Transfer.insert_transfer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // إنشاء سجل في جدول Transfer
        Transfer::create([
            'wallet_id' => $request->wallet_id,
            'sender_name' =>  $request->sender_name,
            'sender_phone' =>  $request->sender_phone,
            'amount_transferred' =>  $request->amount_transferred,
            'transfer_number' =>  $request->transfer_number,
            'transfer_date' =>  $request->transfer_date,
            'transfer_status' =>  "قيد الانتظار",
            'transfer_image' =>  $request->transfer_image,
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
    public function show()
    {
        return view('User.Transfer.user_transfer');
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

        if ($dataToUpdate == "موافقة") {
            // إنشاء كائن AddWalletOperationRequest وتعيين القيم
            $addWalletOperationRequest = new AddWalletOperationRequest();
            $addWalletOperationRequest->merge([
                'wallet_id' => $request->wallet_id, // القيمة المطلوبة لـ wallet_id
                'operation_type' => 1, // القيمة المطلوبة لـ operation_type
                'amount' => $request->amount_transferred, // القيمة المطلوبة لـ amount
                'details' => ' ايداع مقابل حواله بمعرف ' . $request->id . ' و رقم الحوالة ' . $request->transfer_number, // القيمة المطلوبة لـ details
            ]);

            // إنشاء كائن WalletOperationController واستدعاء الدالة store
            $walletOperationController = new WalletOperationController();
            $walletOperationController->store($addWalletOperationRequest);
        }

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
    public function destroy(Request $request)
    {
        if ($request->status == "موافقة") {
            abort(400, 'فشلت العملية بسبب حالة "موافقة"');
        }

        $transfer = Transfer::where('transfer_id', $request->id);

        $transfer->delete();
    }
}
