<?php

namespace App\Http\Controllers;

use App\Models\userinfo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserInfoController extends Controller
{
    public function index()
    {
        return view('Admin.user.user-information');
    }

    // public function getuser()
    // {
    //     $users = userinfo::select('id', 'name', 'phone', 'email')->orderby("id", "ASC")->get();
    //     return response()->json($users);
    // }

    public function getDataTable()
    {
        $model = userinfo::select('id', 'name', 'phone', 'email','created_at')->orderby("id", "ASC");
        return DataTables::of($model)

            ->make(true);
    }

    public function show($id)
    {
        //
    }
}
