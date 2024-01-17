<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCategorieRequest;
use App\Models\Categorie;
use App\Models\SubCategorie;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$model = Categorie::with('supCat')->find(1);
        //return dd($model);

        return view('Admin.Categorie.categories_management');
    }

    public function getCategories()
    {
        $categories = Categorie::select('id', 'name')->orderby("id", "ASC")->get();
        return response()->json($categories);
    }

    public function getSubCategories(Request $request)
{
    $categoryId = $request->input('categoryId');

    // احصل على الفئات الفرعية المترتبطة بالفئة الرئيسية المحددة
    $subCategories = SubCategorie::where('cat_id', $categoryId)->get();

    return response()->json($subCategories);
}


    public function getDataTable()
    {

        $model = Categorie::with('supCat');
        return DataTables::of($model)
            //عرض الرصيد الخاص بالمورد
            /*->addColumn('trens', function (Supplier $supplier) {
                $firstTransaction = $supplier->SuplierTransactions->last();
                return $firstTransaction ? $firstTransaction->balance : null;
            })*/
            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
                <a   data-categorie-id="' . $row->id  . '" type="button" class="delete_btn btn btn-danger">حذف</a>
                <a href="' . route('admin.categories.edit', ['id' => $row->id]) . '"  type="button" class="btn btn-secondary">تحديث</a>
                <a href="' . route('admin.subCategories', ['id' => $row->id]) . '"   type="button" class="btn btn-primary">الفئات الفرعية</a>
                </div>';
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
        return view('Admin.Categorie.insert_categories');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCategorieRequest $request)
    {
        //
        Categorie::create([
            'name' => $request->name,
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

        $categorie = Categorie::where('id', $request->query('id'))->get()->first();

        return view('Admin.Categorie.insert_categories', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddCategorieRequest $request)
    {
        //
        $dataToUpdate = $request->except('id');
        Categorie::where(['id' => $request->id])->update($dataToUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $categorie = Categorie::with('supCat')->find($request->id);

        if($categorie->supCat == '[]') {
                  // لا يوجد supCat
            $categorie->delete();
            return response()->json(['message' => 'تم حذف الفئة بنجاح']);
        }else {
          // يوجد supCat
                abort(400, 'فشلت العملية بسبب وجود فئات فرعية ');
        }
    }
}
