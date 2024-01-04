<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPurchaseRequest extends FormRequest
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

            'sup_id'=>'required',
            'payment_method'=>'required',
            'total'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'sup_id.required'=>' معلومات المورد مطلوبه',
            'payment_method.required'=>' نوع العملية مطلوبه',
            'total.required'=>' الاجمالي مطلوب',
        ];
    }
}
