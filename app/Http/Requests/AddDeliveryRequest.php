<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDeliveryRequest extends FormRequest
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
            'name' => 'required|max:255',
            'shipping_fees' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return[
            'name.required'=>'اسم المورد مطلوب',
            'shipping_fees.required'=>'رسوم الشحن مطلوب',
            'shipping_fees.numeric'=>'يجب ان تحتوي رسوم الشحن على ارقام فقط',
        ];
    }
}
