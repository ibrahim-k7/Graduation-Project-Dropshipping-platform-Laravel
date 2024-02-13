<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddReturnDetailsRequest;
use App\Models\Returndetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReturnDetailsPurchaseController extends Controller
{
    public function index()
    {
        return view('Admin.Purchase.purchaseReturn_management');
    }
    public function create()
    {
        return view('Admin.Purchase.purchase_management');
    }

    public function getDataTable()
    {
        $model = Returndetails::with('purchaseDetails.purchase.supplier');
        return DataTables::of($model)
            ->addColumn('action', function ($row) {
                return '<div class="btn-group" role="group">
                    <button type="button" class="delete_btn btn btn-danger" data-id="' . $row->return_id . '">حذف</button>
                </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function destroy(Request $request)
    {
        try {
            // العثور على سجل مرتجع الفاتورة بناءً على return_id
            $returnDetails = Returndetails::findOrFail($request->return_id);

            // حذف مرتجع الفاتورة
            $returnDetails->delete();

            // العثور على المنتج المرتبط بسجل الاسترجاع
            $product = $returnDetails->purchaseDetails->product;

            if (!$product) {
                return response()->json(['success' => false, 'message' => 'لم يتم العثور على المنتج.']);
            }

            // التحقق من أن الكمية المرتجعة صحيحة وتحديث كمية المنتج
            if ($returnDetails->quantity_returned <= $product->quantity) {
                $product->quantity += $returnDetails->quantity_returned;
                $product->save();

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'كمية المرتجع أكبر من الكمية المتاحة.']);
            }
        } catch (ModelNotFoundException $e) {
            // إذا لم يتم العثور على السجل المناسب
            return response()->json(['success' => false, 'message' => 'لم يتم العثور على سجل مرتجع الفاتورة.']);
        } catch (\Exception $e) {
            // التعامل مع الأخطاء الأخرى
            Log::error('Error processing return: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء معالجة الاسترجاع.']);
        }
    }

}
