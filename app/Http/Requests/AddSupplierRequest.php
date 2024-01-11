<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddSupplierRequest extends FormRequest
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
            'email' =>  'required|max:255|unique:suppliers,email',
            'address' =>  'required|max:255',
            'phone' =>  'required|numeric',
        ];
    }

    public function messages()
    {
        return[
            'name.required'=>'اسم المورد مطلوب',
            'email.required'=>'بريد المورد مطلوب',
            'email.unique'=>'! بريد المورد مستخدم ',
            'address.required'=>'عنوان المورد مطلوب',
            'phone.required'=>'هاتف المورد مطلوب',
        ];
    }
}
