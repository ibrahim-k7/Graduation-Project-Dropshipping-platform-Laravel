<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSubCategorieRequest;
use App\Models\SubCategorie;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->query('id');
        session(['myVariable' => $id]);
        return view('Admin.Categorie.sub_categories');
    }



    public function getDataTable()
    {
        if (session('myVariable') === null) {
            $model = SubCategorie::with('categorie');
        } else {
            $id = session('myVariable');
            $model = SubCategorie::where('cat_id', $id)->select('*')->get();
            session()->forget('myVariable');
        }


        return DataTables::of($model)
            //عرض الرصيد الخاص بالمورد
            ->addColumn('categorie', function (SubCategorie $subCategorie) {
                return  $categorie = $subCategorie->categorie->name;
            })
            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
                <a   data-subCategorie-id="' . $row->id  . '" type="button" class="delete_btn btn btn-danger">حذف</a>
                <a href="' . route('admin.subCategories.edit', ['id' => $row->id]) . '"  type="button" class="btn btn-secondary">تحديث</a>
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

        return view('Admin.Categorie.insert_sub_categorie');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddSubCategorieRequest $request)
    {
        // إنشاء سجل في جدول SubCategorie
        SubCategorie::create([
            'cat_id' => $request->cat_id,
            'name' =>  $request->name,
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
        $subCategorie = SubCategorie::where('id', $request->query('id'))->get()->first();
        return view('Admin.Categorie.insert_sub_categorie', compact('subCategorie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddSubCategorieRequest $request)
    {
        $SubCategorie = SubCategorie::where(['id' => $request->id]);
        // تحديث قيمة الـ name في جدول SupplierTransaction
        $SubCategorie->update(['name' => $request->name]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $subCategorie = SubCategorie::where('id', $request->id);
        $subCategorie->delete();
    }
}
