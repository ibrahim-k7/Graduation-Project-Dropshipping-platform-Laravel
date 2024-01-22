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
        $purchase->products()->attach($request->products);

        // الحصول على المنتجات المضافة في الطلب
        $products = $request->products;

        // تحديث السعر في جدول المنتجات
        foreach ($products as $productData) {
            $product = Product::find($productData['pro_id']);

            if ($product) {
                // تحديث السعر
                $product->update([
                    'purchasing_price' => $productData['purchasing_price'],
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
    public function update(AddPurchaseRequest $request, $id)
    {
        // البحث عن الشراء المطلوب تحديثه
        $purchase = Purchase::findOrFail($id);

        // تحديث البيانات الأساسية
        $purchase->update([
            'sup_id' => $request->sup_id,
            'payment_method' => $request->payment_method,
            'additional_costs' => $request->additional_costs,
            'total' => $request->total,
            'amount_paid' => $request->amount_paid,
        ]);

        // حذف الروابط القديمة للمنتجات المرتبطة
        $purchase->products()->detach();

        // إعادة إضافة الروابط مع المنتجات الجديدة
        $purchase->products()->attach($request->products);

        // تحديث كمية المنتجات
        foreach ($request->products as $productId) {
            $product = Product::findOrFail($productId);

            // التحقق مما إذا كان المنتج موجود
            if ($product) {
                // تحديث كمية المنتج
                $product->update([
                    'quantity' => $product->quantity + $productId["quantity"],
                ]);
            }
        }

        // اختيار العملية بناءً على قيمة الحقل 'action'
        if ($request->action === 'store') {
            // اتخاذ الإجراءات اللازمة للتخزين (إضافة جديدة)
            return redirect()->route('admin.purchase.store')->with('success', 'تم تخزين الشراء بنجاح');
        } elseif ($request->action === 'update') {
            // اتخاذ الإجراءات اللازمة للتحديث
            return redirect()->route('admin.purchase.update')->with('success', 'تم تحديث الشراء بنجاح');
        }
    }
    }

