<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class AddReturnDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'purchase_details_id' => ['required', Rule::exists('purchase details', 'id')],
            'return_date' => 'required',
            'quantity_returned' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    // التحقق من أن الكمية المُرسلة لا تتجاوز الكمية المتاحة في فواتير الشراء
                    $purchaseDetails = \App\Models\PurchaseDetails::find($this->input('purchase_details_id'));

                    if ($purchaseDetails && $value > $purchaseDetails->quantity) {
                        $fail('الكمية المسترجعة أكبر من الكمية المتاحة في فواتير الشراء.');
                    }

                    // التحقق من أن الكمية المسترجعة لا تتجاوز الكمية المشتراة بالفعل
                    $returnedQuantity = $purchaseDetails->returnDetails->sum('quantity_returned') ?? 0;
                    if ($returnedQuantity + $value > $purchaseDetails->quantity) {
                        $fail('الكمية المسترجعة تتجاوز الكمية المشتراة.');
                    }
                },
            ],
            'amount_returned' => 'required',
        ];


}


    public function messages()
    {
        return[
            'purchase_details_id.required'=>' معلومات المنتج مطلوب',
            'return_date.required'=>' تاريخ العملية مطلوب',
            'quantity_returned.required'=>' الكمية مطلوبة  مطلوب',
            'amount_returned.required'=>' الاجمالي مطلوب',

        ];
    }
}
