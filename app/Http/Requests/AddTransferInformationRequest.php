<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTransferInformationRequest extends FormRequest
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

            'name'=>'required|max:255',
            'phone'=>'required|numeric',
            'transfer_network'=>'required|max:255',
        ];
    }

    public function messages()
    {
        return[
            'name.required'=>'الاسم مطلوب',
            'phone.required'=>'رقم هاتف التحويل مطلوب',
            'transfer_network.required'=>'اسم شبكة التحويل مطلوب',
        ];
    }
}
