<?php

namespace App\Http\Controllers;
use App\Models\Purchase;
use App\Models\PurchaseDetails;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseDetailsController extends Controller
{
    public function getDataTable()
    {
//        // تنفيذ الكود الخاص بجلب بيانات تفاصيل المشتريات هنا
      $purchaseDetails = PurchaseDetails::select(['purchDetails_id', 'purch_id', 'pro_id', 'quantity', 'total_cost']);
//            ->orderBy('id', 'desc')
//            ->get();
//       return response()->json(['data' => $purchaseDetails]);
    }
    public function index()
    {
// احصل على جميع المشتريات مع تفاصيلها وقم بعرضها في الصفحة
        $purchases = Purchase::with('purchaseDetails')->get();
        return view('Admin.purchase.index', compact('purchases'));
    }

    public function edit($id)
    {
// احصل على معلومات المشتريات وتفاصيلها للتعديل
        $purchase = Purchase::with('purchaseDetails')->find($id);
        return view('Admin.purchase.edit', compact('purchase'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
// قم بتحديث بيانات المشتريات وتفاصيلها
        $validator = Validator::make($request->all(), [
// أضف قواعد الصحة الخاصة بالتحديث هنا
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

// اكمل التحديث حسب حاجتك

        return redirect()->route('admin.purchases.index')->with('success', 'تم تحديث المشتريات بنجاح.');
    }

    // يمكنك إضافة المزيد من الوظائف حسب احتياجاتك
}
