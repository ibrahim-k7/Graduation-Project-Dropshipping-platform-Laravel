<?php

namespace App\Http\Controllers;

use App\Models\PurchaseDetails;
use Illuminate\Http\Request;

class PurchaseDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Purchase.purchase_management');
    }

    public function getPurchaseDetails()
    {
        $purchaseDetails = PurchaseDetails::select('id', 'name')->orderBy("id", "ASC")->get();
        return response()->json($purchaseDetails);
    }

    // الدالة لجلب تفاصيل المشتريات المرتبطة بالاسترجاع

}
