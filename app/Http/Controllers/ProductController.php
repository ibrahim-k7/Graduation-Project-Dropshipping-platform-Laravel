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
            'image' =>  $request->image,
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
}
