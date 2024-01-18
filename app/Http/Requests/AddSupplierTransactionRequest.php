<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddSupplierTransactionRequest extends FormRequest
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
            'transaction_type'=>'required',
            'amount'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'sup_id.required'=>' معلومات المورد مطلوبه',
            'transaction_type.required'=>' نوع العملية مطلوبه',
            'amount.required'=>' المبلغ مطلوب'
        ];
    }
}
