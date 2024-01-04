<?php
// app/Http/Controllers/PurchaseController.php
namespace App\Http\Controllers;

use App\Http\Requests\AddPurchaseRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Returndetails;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PurchaseController extends Controller
{

    public function index()
    {
 
        return  view('Admin.Purchase.purchase_management');
    }

    public function getDataTable()
    {

        $data = Purchase::with('supplier')->with('prouduct');

        return DataTables::of($data)->addIndexColumn()
            ->addColumn('supplier', function (Purchase $purchase) {
                return $result = $purchase->supplier->name;
            })
            ->addColumn('action', function ($row) {
                return $btn = '<div class="btn-group" role="group">
                <a href="' . route('admin.supplier.transaction.edit', ['id' => $row->transaction_id]) . '"  type="button" class="btn btn-secondary">تحديث</a>
                <a   id="delete_btn" data-transaction-id="' . $row->transaction_id  . '" type="button" class="delete_btn btn btn-danger">حذف</a>
                </div>
            ';
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
            'payment_method' =>  $request->payment_method,
            'additional_costs' =>  $request->additional_costs,
            'total' =>  $request->total,
            'amount_paid' => $request->amount_paid,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $purchase = Purchase::latest()->first();
        $purchase->prouduct()->attach($request->products);

        // الحصول على المنتجات المضافة في الطلب

        $products = $request->products;



        // تحديث كمية المنتجات
        foreach ($products as $productId ) {

            $product = Product::where('id',$productId)->first();

            // التحقق مما إذا كان المنتج موجود
            if ($product) {
                // تحديث كمية المنتج
                $product->update([
                    'quantity' => $product->quantity + $productId["quantity"],
                ]);

            }
        }

        //return $request;
        /*  $validator = Validator::make($request->all(), [
            'payment_method' => 'required',
            'sup_ID' => 'required',
            'extra_expenses' => 'required',
            'total' => 'required',
            'amount_paid' => 'required',
            'purchase_details' => 'required|array|min:1',
            'purchase_details.*.pro_id' => 'required',
            'purchase_details.*.quantity' => 'required',
            'purchase_details.*.total_cost' => 'required',
            // أضف باقي الحقول هنا
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $purchase = Purchase::create([
            'payment_method' => $request->input('payment_method'),
            'sup_ID' => $request->input('sup_ID'),
            'extra_expenses' => $request->input('extra_expenses'),
            'total' => $request->input('total'),
            'amount_paid' => $request->input('amount_paid'),
            // أضف باقي الحقول هنا
        ]);

        // احفظ تفاصيل المشتريات
        $purchaseDetails = $request->input('purchase_details');
        foreach ($purchaseDetails as $detail) {
            PurchaseDetail::create([
                'purch_id' => $purchase->purch_ID,
                'pro_id' => $detail['pro_id'],
                'quantity' => $detail['quantity'],
                'total_cost' => $detail['total_cost'],
                // أضف باقي الحقول هنا
            ]);
        }

        return redirect()->route('admin.purchases.index')->with('success', 'تم إضافة المشتريات بنجاح.');*/
    }


    /*  public function return()
    {
        // صفحة استعادة المشتريات
        return view('Admin.purchase.Returndetails');
    }*/

    public function processReturn(Request $request): \Illuminate\Http\RedirectResponse
    {
        // معالجة طلب الاسترجاع وتحديث الكميات والمبالغ
        $validator = Validator::make($request->all(), [
            'purchase_details_id' => 'required',
            'return_date' => 'required',
            'quantity_returned' => 'required',
            'amount_returned' => 'required',
            // أضف باقي الحقول هنا
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // اكمل معالجة الاسترجاع حسب حاجتك

        return redirect()->route('admin.purchases.index')->with('success', 'تم استعادة المشتريات بنجاح.');
    }
}
