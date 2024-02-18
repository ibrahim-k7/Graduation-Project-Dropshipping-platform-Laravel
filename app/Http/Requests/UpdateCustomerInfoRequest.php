<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerInfoRequest extends FormRequest
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
            'customer_name' => 'required|max:255',
            'customer_phone' => 'required|numeric',
            'customer_email' => 'required|email',
            'shipping_address' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return[
            'customer_name.required'=>'اسم العميل مطلوب',
            'customer_phone.required'=>'هاتف العميل مطلوب',
            'customer_email.required'=>'البريد الالكتروني للعميل مطلوب',
            'customer_email.email'=>'يجب أن يكون البريد الإلكتروني للعميل عنوان بريد إلكتروني صالحًا',
            'shipping_address.required'=>'عنوان العميل مطلوب',
        ];
    }
}
