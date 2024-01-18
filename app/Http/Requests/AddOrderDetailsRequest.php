<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddOrderDetailsRequest extends FormRequest
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
            'order_details_id'=>'required',
            'quantity'=>'required|numeric',
            'total_cost'=>'required|numeric',
        ];
    }

    public function messages()
    {
        return[
            'wallet_id.required'=>' معلومات المنتج مطلوبه',
            'quantity.required'=>' الكمية مطلوبة',
            'quantity.numeric'=>'الكمية يجب ان تكون رقما',
            'total_cost.required'=>' اجمالي المنتج مطلوب',
            'total_cost.numeric'=>' اجمالي المنتج يجيب ان يكون رقماً',
        ];
    }
}
