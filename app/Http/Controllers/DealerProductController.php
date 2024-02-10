<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\DealerProduct;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;





class DealerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.sellerproducts.products');
    }

    public function getSellerProducts()
    {
        $sellerProducts = Product::select('*')->get();

        return view('user.sellerproducts.products');
    }


    public function getDataTable()
    {
        // استخراج store_id من المستخدم المسجل الحالي
        $store_id = Auth::user()->store_id;
        // استخراج معرف المحفظة 
        //  $wallet_id = Wallet::where('store_id', $store_id)->value('wallet_id');
        $model = DealerProduct::where('store_id', $store_id)->select('*')->get();
        return DataTables::of($model)
            ->addColumn('productName', function (DealerProduct $dealerProduct) {
                return $result = $dealerProduct->product->name;
            })
            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
                <a   data-product-id="' . $row->id  . '" type="button" class="delete_btn btn btn-danger">حذف</a>
                <a href="' . route('admin.products.edit', ['id' => $row->id]) . '"  type="button" class="btn btn-secondary">تحديث</a>
                <a href="' . route('admin.subCategories', ['id' => $row->id]) . '"   type="button" class="btn btn-primary">المبيعات</a>
                <a href="' . route('admin.subCategories', ['id' => $row->id]) . '"   type="button" class="btn btn-primary">المشتريات</a>
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
    public function create($id)
    {
        $details = Product::find($id);
        $store_id = Auth::user()->store_id;
        $dealerProduct = DealerProduct::where('store_id', $store_id)->select('*')->get();

        DealerProduct::create([
            'store_id' => $store_id,
            'pro_id' => $details->id,
            'dealer_selling_price' => $details->suggested_selling_price,
            'dealer_product_name' => $details->name,
            'dealer_product_desc' => $details->description,
            'platform' => 'سلة',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
      //  return view('user.products.product_details');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // استخراج store_id من المستخدم المسجل الحالي
       $store_id = Auth::user()->store_id;
       // استخراج معرف المحفظة 
       $_id = DealerProduct::where('store_id', $store_id)->value('store_id');
              // إنشاء سجل في جدول Product
              DealerProduct::create([
                'store_id' => $store_id,
                'pro_id' => $request->pro_id,
                'dealer_selling_price' => $request->suggested_selling_price,
                'dealer_product_desc' => $request->description,
                'quantity' => 0,
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
        return view('user.sellerproducts.products');
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
