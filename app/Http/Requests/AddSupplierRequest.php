<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $id = $this->get('id'); // Retrieve the 'id' from the request

        
        return [
            'name' => 'required|max:255',
            'email' => [
                'required',
                'max:255',
                Rule::unique('suppliers', 'email')->ignore($id, 'sup_id')
            ],
            'address' => 'required|max:255',
            'phone_number' => 'required|numeric',
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
