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

        $purchase = Purchase::latest()->first();
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

    public
    function edit(Request $request)
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
    public function update(AddPurchaseRequest $request, $id)
    {
        // تحديث المعلومات الرئيسية للشراء
        $purchase = Purchase::findOrFail($id);
        $purchase->update([
            'amount_paid' => $request->amount_paid,
            'payment_method' => $request->payment_method,
            'additional_costs' => $request->additional_costs,
        ]);

        // الحصول على المنتجات المضافة في الطلب
        $products = $request->products;
        //dd($purchase->products());
        // تحديث المنتجات في قاعدة البيانات
        foreach ($products as $productId) {
            // استخدام المعرف للتحقق من وجود المنتج في الشراء
            $purchaseDetail = PurchaseDetails::where(['purch_id' => $id, 'pro_id' => $productId])->first();

            if ($purchaseDetail) {
                // تحديث المنتج إذا كان موجودًا
                $purchaseDetail->update([
                    'quantity' => $productId["quantity"],
                    'purchasing_price' => $productId["purchasing_price"],
                ]);
            } else {
                // إذا لم يكن المنتج موجودًا، قم بإضافته
                $purchase->products()->attach($productId['pro_id'], [
                    'quantity' => $productId["quantity"],
                    'purchasing_price' => $productId["purchasing_price"],
                ]);
            }
        }

        // إذا كان هناك منتجات تم حذفها، قم بإزالتها
        $deletedProducts = collect($request->original_products)->pluck('pro_id')->diff(collect($products)->pluck('pro_id'));
        $purchase->products()->detach($deletedProducts);

        // تحديث كمية المنتجات
        foreach ($products as $productId) {
            $product = Product::findOrFail($productId["pro_id"]);
            $product->update([
                'quantity' => $product->quantity + $productId["quantity"],
                'purchasing_price' => $productId["purchasing_price"],
            ]);
        }

        return redirect()->route('purchase.index')->with('success', 'تم تحديث الشراء بنجاح!');
    }



    public function getPurchaseInvoices()
    {
        // Get all purchase invoices with associated details and products
        $invoices = Purchase::with('purchaseDetails.product')
            ->orderBy("id", "ASC")
            ->get();

        return response()->json($invoices);
    }



    // الدالة لعرض صفحة استعادة المشتريات
    public function returnDetails()
    {
        // قدم قائمة بجميع الفواتير المتاحة للاسترجاع مع تفاصيلها
        $purchases = Purchase::with('purchaseDetails.product')->get();

        return view('Admin.Purchase.Returndetails', compact('purchases'));
    }


    // الدالة لمعالجة عملية الاسترجاع
    public function processReturn(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'return_date' => 'required|date',
            'quantity_returned' => 'required|integer|min:1',
            'amount_returned' => 'required|numeric|min:0',
        ]);

        // قد يتعين عليك تحديد مودل Purchase بناءً على هيكل قاعدة البيانات الخاص بك
        $purchase = Purchase::find($request->purchase_id);

        if (!$purchase) {
            return redirect()->back()->with('error', 'الفاتورة غير موجودة.');
        }

        // إنشاء عملية الاسترجاع
        $returnDetails = ReturnDetails::create([
            'purchase_details_id' => $request->purchase_id,
            'return_date' => $request->return_date,
            'quantity_returned' => $request->quantity_returned,
            'amount_returned' => $request->amount_returned,
        ]);

        // تحديث الأرصدة أو أي عمليات إضافية حسب الحاجة
        $product = Product::find($purchase->product_id);

        if ($product) {
            $newStockQuantity = $product->quantity - $request->quantity_returned;
            $product->quantity = max(0, $newStockQuantity);
            $product->save();
        }

        return redirect()->route('admin.purchase.returnDetails')->with('success', 'تمت عملية الاسترجاع بنجاح.');
    }
}
