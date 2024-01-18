<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnOrderRequest extends FormRequest
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
            'quantity_returned' => 'required|numeric',
            'amount_returned' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return[
            'quantity_returned.required'=>'يجب ادخال الكمية المسترجعة',
            'quantity_returned.numeric'=>'يجب ان تحتوي الكمية المسترجعة على ارقام فقط',
            'amount_returned.required'=>'المبلغ المسترجع مطلوب',
            'amount_returned.numeric'=>'يجب ان تحتوي المبلغ المسترجعة على ارقام فقط',
        ];
    }
}
