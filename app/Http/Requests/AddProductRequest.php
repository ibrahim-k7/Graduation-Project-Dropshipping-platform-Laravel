<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name'=>'required',
            'cat_id'=>'required',
            'subCat_id'=>'required',
            'weight'=>'required',
           // 'image'=>'required|max:1024|mimes:png,jpg,jpeg',
        ];
    }

    public function messages()
    {
        return[
            'name.required'=>'اسم المنتج مطلوب',
            'cat_id.required'=>'الفئة الرئيسية مطلوبة',
            'subCat_id.required'=>'الفئة الفرعية مطلوبة',
            'weight.required'=>'وزن المنتج مطلوب',
           //    'image.required'=>'صورة المنتج مطلوبة',
        ];
    }
}
