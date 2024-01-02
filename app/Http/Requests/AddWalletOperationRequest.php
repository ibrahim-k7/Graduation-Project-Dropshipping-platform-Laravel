<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddWalletOperationRequest extends FormRequest
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
            'wallet_id'=>'required',
            'operation_type'=>'required',
            'amount'=>'required|numeric',
            'details'=>'required|max:255',
        ];
    }

    public function messages()
    {
        return[
            'wallet_id.required'=>' معلومات المحفظة مطلوبه',
            'operation_type.required'=>' نوع العملية مطلوبه',
            'amount.required'=>' المبلغ مطلوب',
            'amount.numeric'=>' المبلغ يجيب ان يكون رقماً',
            'details.required'=>'تفاصيل العملية مطلوبه',
        ];
    }
}
