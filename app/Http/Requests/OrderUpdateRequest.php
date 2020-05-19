<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
        $rules = [
            'name'           => 'required|max:200|min:2',
            'client_email'   => 'required|email|max:200',
            'status'         => 'required'
        ];

        return $rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'         => "Вам нужно заполнить поле 'Партнер'",
            'name.min'              => "Имя партнера не может быть менее 2 симвовлов",
            'name.max'              => "Имя партнера не может быть длиннее 200 симвовлов",
            'client_email.required' => "Вам нужно заполнить поле 'Email'",
            'client_email.email'    => "Введите действительный email",
            'client_email.max'      => "Вряд ли email такой длинный",
            'status.required'       => "На странице ошибка, обратитесь к администратору",
        ];
    }

}
