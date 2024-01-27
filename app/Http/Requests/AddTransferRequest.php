<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTransferRequest extends FormRequest
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
           // 'wallet_id'=>'required',
            'sender_name'=>'required',
            'sender_phone'=>'required',
            'amount_transferred'=>'required',
            'transfer_number'=>'required',
            'transfer_date'=>'required',
            'transfer_image'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'sender_name.required'=>'اسم المرسل مطلوب',
            'sender_phone.required'=>'رقم هاتف المرسل مطلوب',
            'amount_transferred.required'=>'مبلغ الحوالة مطلوب',
            'transfer_number.required'=>'رقم الحوالة مطلوب',
            'transfer_date.required'=>'تاريخ التحويل مطلوب',
            'transfer_image.required'=>'صورة سند الحوالة مطلوبة'
        ];
    }
}
