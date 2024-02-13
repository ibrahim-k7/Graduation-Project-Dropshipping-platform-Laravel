<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Admininfo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminInfoController extends Controller
{
    public function index()
    {
        return view('Admin.user.admin-information');
    }

    // public function getuser()
    // {
    //     $users = userinfo::select('id', 'name', 'phone', 'email')->orderby("id", "ASC")->get();
    //     return response()->json($users);
    // }

    public function getDataTable()
    {
        $model = Admininfo::select('id', 'name', 'email','created_at')->orderby("id", "ASC");
        return DataTables::of($model)

            ->make(true);
    }

    public function show($id)
    {
        //
    }
}
