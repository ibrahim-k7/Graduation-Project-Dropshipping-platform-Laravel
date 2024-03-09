<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAPIRequest extends FormRequest
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
            'domain'=>'required',
            'secret'=>'required',
            'key'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'domain.required'=>'ال Domain مطلوب',
            'secret.required'=>'ال secret مطلوب',
            'key.required'=>'ال key مطلوب',
        ];
    }
}
