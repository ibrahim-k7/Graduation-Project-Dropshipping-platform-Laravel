<?php
// app/Http/Controllers/PurchaseController.php
namespace App\Http\Controllers;

use App\Http\Requests\AddPurchaseRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Returndetails;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PurchaseController extends Controller
{

    public function index()
    {

        return view('Admin.Purchase.purchase_management');
    }

    public function getDataTable()
    {

        $data = Purchase::with('supplier')->with('prouduct');

        return DataTables::of($data)->addIndexColumn()
            ->addColumn('supplier', function (Purchase $purchase) {
                return $result = $purchase->supplier->name;
            })
            ->addColumn('action', function ($row) {
                return '<div class="btn-group" role="group">
                    <a href="' . route('admin.Purchase.edit', ['id' => $row->id]) . '" type="button" class="btn btn-secondary">تفاصيل الفاتورة </a>
                    <a id="delete_btn" data-transaction-id="' . $row->id . '" type="button" class="delete_btn btn btn-danger">حذف</a>
                </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('Admin.purchase.insert_Purchase');
    }

    public function store(AddPurchaseRequest $request)
    {

        Purchase::create([
            'sup_id' => $request->sup_id,
            'payment_method' => $request->payment_method,
            'additional_costs' => $request->additional_costs,
            'total' => $request->total,
            'amount_paid' => $request->amount_paid,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $purchase = Purchase::orderBy('id', 'desc')->first();
        // استخدام array_map لتطبيق except على كل عنصر في المصفوفة
        $productsDataE = array_map(function ($product) {
            return collect($product)->except('purchasing_price')->toArray();
        }, $request->products);
        $purchase->prouduct()->attach($productsDataE);

        // الحصول على المنتجات المضافة في الطلب

        $products = $request->products;


        // تحديث كمية المنتجات
        foreach ($products as $productId) {

            $product = Product::where('id', $productId)->first();

            // التحقق مما إذا كان المنتج موجود
            if ($product) {
                // تحديث كمية المنتج
                $product->update([
                    'quantity' => $product->quantity + $productId["quantity"],
                    'purchasing_price' => $productId["purchasing_price"],
                ]);

            }
        }
    }

    public function edit(Request $request)
    {
        $purchase = Purchase::with('supplier')->with('purchaseDetails.product')->find($request->query('id'));

        // تحقق مما إذا كان هناك معلومات حول الشراء
        return view('Admin.purchase.insert_Purchase', compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddPurchaseRequest $request)
    {
        // تحديث المعلومات الرئيسية للشراء
        $purchase = Purchase::findOrFail($request->id);
        $purchase->update([
            'sup_id' => $request->sup_id,
            'total'=>$request->total,
            'amount_paid' => $request->amount_paid,
            'payment_method' => $request->payment_method,
            'additional_costs' => $request->additional_costs,
        ]);

        // الحصول على المنتجات المضافة في الطلب
        $products = $request->products;
        //تحديث المنتجات في قاعدة البيانات
        foreach ($products as $productId) {
            // استخدام المعرف للتحقق من وجود المنتج في تفاصيل المشتريات
            $purchaseDetail = PurchaseDetails::where(['purch_id' => $request->id, 'pro_id' => $productId])->first();
            $purchaseDetailQuantity = PurchaseDetails::select('quantity')->where(['purch_id' => $request->id, 'pro_id' => $productId])->first();

            //الاستعلام بالمنتج
            $product = Product::findOrFail($productId["pro_id"]);

            if ($purchaseDetail) {
                // تحديث المنتج إذا كان موجودًا
                $newQuantity = $productId["quantity"] - $purchaseDetailQuantity['quantity'];
                $product->update([
                    'quantity' => $product->quantity + $newQuantity,
                    'purchasing_price' => $productId["purchasing_price"],
                ]);

                $purchaseDetail->update([
                    'quantity' => $productId["quantity"],
                    'total_cost' => $productId["total_cost"],
                ]);
            } else {
                // إذا لم يكن المنتج موجودًا، قم بإضافته

                $purchase = Purchase::findOrFail($request->id);
                $purchase->prouduct()->attach($productId['pro_id'], [
                    'quantity' => $productId["quantity"],
                    'total_cost' => $productId["total_cost"],
                ]);

                $product->update([
                    'quantity' => $product->quantity + $productId["quantity"],
                    'purchasing_price' => $productId["purchasing_price"],
                ]);
            }



        }
        return redirect()->route('admin.purchase.index')->with('success', 'تم تحديث الشراء بنجاح!');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
//      public function return()
//    {
//        // معالجة طلب الاسترجاع وتحديث الكميات والمبالغ
//        $PurchaseReturn = PurchaseReturn::make($request->all(), [
//            'purchase_details_id' => 'required',
//            'return_date' => 'required',
//            'quantity_returned' => 'required',
//            'amount_returned' => 'required',
//            // أضف باقي الحقول هنا
//        ]);
//
//        if ($PurchaseReturnPurchaseReturn->fails()) {
//            return redirect()->back()->withErrors($validator)->withInput();
//        }
//
//        // اكمل معالجة الاسترجاع حسب حاجتك
//
//        return redirect()->route('admin.purchases.index')->with('success', 'تم استعادة المشتريات بنجاح.');
//        // صفحة استعادة المشتريات
//        return view('Admin.purchase.Returndetails');
//    }

}
