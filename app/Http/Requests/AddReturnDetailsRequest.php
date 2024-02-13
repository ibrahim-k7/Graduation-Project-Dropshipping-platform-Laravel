<?php

namespace App\Http\Requests;

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

            'purchase_details_id'=>'required',
            'return_date'=>'required',
            'quantity_returned'=>'required',
            'amount_returned'=>'required',

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
