<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class AddProductRequest extends FormRequest
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
            'name' => 'required',
            'cat_id' => 'required',
            'subCat_id' => 'required',
            'barcode' => [
                'required',
                Rule::unique('products', 'barcode')->ignore($id, 'id')
            ],
            'weight' => 'required',
            'image' => 'required|max:1024|mimes:png,jpg,jpeg',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم المنتج مطلوب',
            'cat_id.required' => 'الفئة الرئيسية مطلوبة',
            'subCat_id.required' => 'الفئة الفرعية مطلوبة',
            'barcode.required'=>'باركود المنتج مطلوب',
            'barcode.unique'=>'الباركود مستخدم !',
            'weight.required' => 'وزن المنتج مطلوب',
            'image.required' => 'صورة المنتج مطلوبة',
        ];
    }
}
