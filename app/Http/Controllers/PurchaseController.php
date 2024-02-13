<?php
// app/Http/Controllers/PurchaseController.php
namespace App\Http\Controllers;

use App\Http\Requests\AddPurchaseRequest;
use App\Http\Requests\AddReturnDetailsRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Returndetails;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
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
                    <a href="' . route('admin.purchase.returnDetails', ['id' => $row->id]) . '" type="button" class="btn btn-secondary">اضافة مرتجع</a>
                    <a id="delete_btn" purch-id="' . $row->id . '" type="button" class="delete_btn btn btn-danger">حذف</a>
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

        // الحصول على المنتجات المحدثة في الطلب
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

        // حذف المنتجات من تفاصيل المشتريات عند تعديل الفاتورة
        //لايجاد المنتجات المحذوفة من الفاتورة
        $proIds = collect($products)->pluck('pro_id')->toArray();
        $purchaseDetails = PurchaseDetails::where(['purch_id' => $request->id])->get('pro_id');
        $purchaseDetailsProIds = collect($purchaseDetails)->pluck('pro_id')->toArray();

        //استدعاء معرف المنتج المحذوف
        $deletedPurchaseDetails = collect($purchaseDetailsProIds)->diff($proIds)->toArray();

        //الوصول الى جميع المنتجات المحذوفة في قاعدة البيانات
        foreach ($deletedPurchaseDetails as $deletedPurchaseDetail){
            //الوصول الى كمية المنتج المحذوف في تفاصيل المشتريات
            $purchaseDetailsQuantity = PurchaseDetails::select('quantity')
                ->where(['purch_id' => $request->id, 'pro_id' => $deletedPurchaseDetail])->first();

            //نقص كمية المنتج بعد حذفه من تفاصيل المشتريات
            $product = Product::findOrFail($deletedPurchaseDetail);
            $product->update([
                'quantity' => $product->quantity - $purchaseDetailsQuantity->quantity,
            ]);

            $purchase->prouduct()->detach($deletedPurchaseDetail);
        }

        return redirect()->route('admin.purchase.index')->with('success', 'تم تحديث الشراء بنجاح!');
    }

    public function destroy(Request $request){
        //الوصول الى تفاصيل المشتريات حسب معرف الفاتورة
        $purchaseDetailProIds = PurchaseDetails::select('pro_id')->where('purch_id',$request->id)->get();
        foreach ($purchaseDetailProIds as $purchaseDetail){
            $proId = $purchaseDetail->pro_id;

            //استدعاء كمية المنتج في فاتورة تفاصيل المشتريات
            $purchaseDetailQuantity = PurchaseDetails::select('quantity')
                ->where(['purch_id' => $request->id, 'pro_id' => $proId])->first();

            $product = Product::findOrFail($proId);

            $product->update([
                'quantity' =>  $product->quantity - $purchaseDetailQuantity->quantity,
            ]);
        }

        Purchase::destroy($request->id);
    }

    public function getPurchaseInvoices()
    {
        // Get all purchase invoices with associated details and products
        $invoices = Purchase::with(['purchaseDetails.product'])
            ->select('id')// اختر الحقول التي تحتاجها هنا
            ->orderBy("id", "ASC")
            ->get();

        return response()->json($invoices);
    }

    public function getPurchaseDetails($id)
    {
        $purchaseDetails = PurchaseDetails::with('product:id,name')->where('purch_id', $id)->get(['id', 'quantity']);

        return response()->json($purchaseDetails);
    }

    // الدالة لعرض صفحة استعادة المشتريات
    public function returnDetails(Request $request)
    {
        $purchase = Purchase::with('supplier')->with('purchaseDetails.product')->find($request->query('id'));

        // تحقق مما إذا كان هناك معلومات حول الشراء
        return view('Admin.Purchase.Returndetails', compact('purchase'));
    }


    // الدالة لمعالجة عملية الاسترجاع
    public function processReturn(AddReturnDetailsRequest $request)
    {
        try {
            // إنشاء سجل استرجاع
            $returnDetails = Returndetails::create([
                'purchase_details_id' => $request->purchase_details_id,
                'return_date' => $request->return_date,
                'quantity_returned' => $request->quantity_returned,
                'amount_returned' => $request->amount_returned,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // العثور على المنتج المرتبط بسجل الاسترجاع
            $product = $returnDetails->purchaseDetails->product;

            if (!$product) {
                return response()->json(['success' => false, 'message' => 'لم يتم العثور على المنتج.']);
            }

            // التحقق من أن الكمية المرتجعة صحيحة وتحديث كمية المنتج
            if ($returnDetails->quantity_returned <= $product->quantity) {
                $product->quantity -= $returnDetails->quantity_returned;
                $product->save();

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'كمية المرتجع أكبر من الكمية المتاحة.']);
            }
        } catch (ValidationException $e) {
            // التعامل مع الأخطاء التي تنتج عن الصحة
            return response()->json(['success' => false, 'message' => $e->errors()]);
        } catch (\Exception $e) {
            // التعامل مع الأخطاء الأخرى
            Log::error('Error processing return: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء معالجة الاسترجاع.']);
        }
    }
}
