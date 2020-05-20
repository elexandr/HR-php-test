<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|numeric',
            'price' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'price.required'  =>  'Поле цены не может быть пустым',
            'price.numeric'   =>  'Цена может содержать только цифровое значение',
        ];
    }
}
