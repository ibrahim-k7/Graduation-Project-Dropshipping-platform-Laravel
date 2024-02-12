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
        $model = DealerProduct::where('store_id', $store_id)->with('product')->select('*')->get();
        return DataTables::of($model)
            ->addColumn('quantity', function (DealerProduct $dealerProduct) {
                return $result = $dealerProduct->product->quantity;
            })
            ->addColumn('image', function (DealerProduct $dealerProduct) {
                return $result = $dealerProduct->product->image;
            })
            ->addColumn('barcode', function (DealerProduct $dealerProduct) {
                return $result = $dealerProduct->product->barcode;
            })
            ->addColumn('categorie', function (DealerProduct $dealerProduct) {
                return $result = $dealerProduct->product->categorie->name;
            })
            ->addColumn('subCategorie', function (DealerProduct $dealerProduct) {
                return $result = $dealerProduct->product->subCategorie->name;
            })
            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
                <a   data-product-id="' . $row->dealer_pro_id. '" type="button" class="delete_btn btn btn-danger">حذف</a>
                <a href="' . route('user.dealer.product.details', ['id' => $row->dealer_pro_id]) . '"  type="button" class="btn btn-secondary">تحديث</a>
                <a href="' . route('admin.subCategories', ['id' => $row->dealer_pro_id]) . '"   type="button" class="btn btn-primary">إضافة للسله</a>
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
    public function create(Request $request)
    {
        $id = $request->query('id');

        $details = DealerProduct::with('product')->where('dealer_pro_id', $id)->select('*')->first();

        return view('user.sellerproducts.dealer_product_details', compact('details'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $details = Product::find($request->id);
        $store_id = Auth::user()->store_id;
        $existingProduct = DealerProduct::where('store_id', $store_id)
            ->where('pro_id', $request->id)
            ->first();
        if ($existingProduct) {
            abort(400, 'فشلت العملية    ');
        } else {
            // إذا لم يكن هناك منتج بنفس الـ pro_id، قم بإضافة المنتج
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
        }
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
    public function update(Request $request)
    {
        $dataToUpdate = $request->except('id');
        $dataToUpdate = $request->except('oldImgName');
       
        DealerProduct::where(['dealer_pro_id' => $request->id])->update($dataToUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dealerProduct = DealerProduct::where('dealer_pro_id', $request->id);
        $dealerProduct->delete();
        
    }
}
