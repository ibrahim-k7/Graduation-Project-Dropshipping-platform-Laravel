<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAPIRequest;
use App\Models\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;


class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function getById(Request $request)
    {
        $data = API::where('id', $request->id)->select('*')->first();
        return $data;
    }

    public function getDataTable()
    {
        // استخراج store_id من المستخدم المسجل الحالي
        $store_id = Auth::user()->store_id;
        // استخراج معرف المحفظة 
        //  $wallet_id = Wallet::where('store_id', $store_id)->value('wallet_id');
        $model = API::where('store_id', $store_id)->select('*');
        return DataTables::of($model)
            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
                <a   data-api-id="' . $row->id . '" type="button" class="delete_btn btn btn-danger">حذف</a>
                <a   data-api-id="' . $row->id . '" type="button" class="update_btn btn btn-secondary">تحديث</a>
                </div>  ';
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
    public function store(AddAPIRequest $request)
    {

        $store_id = Auth::user()->store_id;

        if (API::where('store_id', $store_id)->exists()) {
            throw ValidationException::withMessages([
                'store_id' => ['لديك سجل API موجود بالفعل.'],
            ]);
        } else {
            API::create([
                'store_id' => $store_id,
                'domain' =>  $request->domain,
                'secret' =>  $request->secret,
                'key' =>  $request->key,
            ]);
        }



        // مهم جدا سيتم العودة له بعدين
        // $model = API::where('store_id', $store_id)->with('store')->first();
        // return dd($model->store->store_id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        return view('User.API_connect.insert_API_connect');
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
    public function update(AddAPIRequest $request)
    {
        $dataToUpdate = $request->except('id');
        API::where(['id' => $request->id])->update($dataToUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $api = API::where('id', $request->id);
        $api->delete();
    }
}
