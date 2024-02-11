<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('Admin.Products.products_management');
    }

    public function getProducts()
    {
        $products = Product::select('id', 'name')->orderby("id", "ASC")->get();
        return response()->json($products);
    }

    public function getAllProducts()
    {
        $products = Product::select('*')->get();
        return view('user.products.product_catalogue', compact('products'));
    }

     public function getProductDetails(int $id){
//$details = Product::select('*')->get();
        $details = Product::find($id);
        if(!$details){
            abort(404);
        }

         return view ('user.products.product_details',compact('details'));   
     }
    // public function getProductDetails()
    // {
    //     $details = Product::select('*')->get();
    //     return view('user.products.product_details', compact('details'));
    // }

    public function getSellerProducts()
    {
        $sellerProducts = Product::select('*')->get();
        return view('user.sellerproducts.products', compact('sellerProducts'));
    }



    //إعادة عدد المنتجات المتوفره في قاعدة البيانات
    public function getProductsCount()
    {
        $productsCount = Product::count();
        return response()->json(['count' => $productsCount]);
    }

    public function getLowQuantityProducts()
    {

        $data = Product::select('id', 'name', 'image', 'quantity', 'barcode')
            ->whereBetween('quantity', [0, 5])
            ->get();

        return response()->json($data);
    }


    public function getDataTable()
    {
        $model = Product::with('categorie')->with('subCategorie');
        return DataTables::of($model)
            ->addColumn('categorie', function (Product $product) {
                return $result = $product->categorie->name;
            })
            ->addColumn('subCategorie', function (Product $product) {
                return $result = $product->subCategorie->name;
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
    public function create()
    {
        //
        return view('Admin.Products.insert_product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddProductRequest $request)
    {

        $file_name = $this->upload("Products_img", $request->image);
        // إنشاء سجل في جدول Product
        Product::create([
            'name' => $request->name,
            'selling_price' => $request->selling_price,
            'suggested_selling_price' => $request->suggested_selling_price,
            'barcode' => $request->barcode,
            'description' => $request->description,
            'cat_id' =>  $request->cat_id,
            'subCat_id' =>  $request->subCat_id,
            'weight' =>  $request->weight,
            'image' =>  $file_name,
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
        $product = Product::where('id', $request->query('id'))->get()->first();
        return view('Admin.Products.insert_product', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddProductRequest $request)
    {
        //
        $dataToUpdate = $request->except('id');
        $dataToUpdate = $request->except('oldImgName');
        if ($request->hasFile('image')) {
            $file_name = $this->upload("Products_img", $request->file('image'));
            $deleteImg = $this->deleteImage("Products_img", $request->oldImgName);
            $dataToUpdate['image'] = $file_name;
        }
        Product::where(['id' => $request->id])->update($dataToUpdate);
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
        $product = Product::where('id', $request->id);
        $quantity = $product->value('quantity');

        if ($quantity !== null) {
            // إذا كانت قيمة $quantity تساوي null
            abort(400, 'فشلت العملية بسبب وجود كمية للمنتج: ');
        } else {
            $product->delete();
        }
    }

    protected function upload($folderStoringPath, $image)
    {
        $extension = strtolower($image->extension());
        $filename = time() . rand(1, 10000) . "." . $extension;
        $image->move($folderStoringPath, $filename);
        return $filename;
    }

    protected function deleteImage($folderStoringPath, $filename)
    {
        $filePath = $folderStoringPath . '/' . $filename;

        // التحقق من وجود الملف قبل محاولة حذفه
        if (file_exists($filePath)) {
            unlink($filePath);
            // تم حذف الملف بنجاح
        }
    }
}
