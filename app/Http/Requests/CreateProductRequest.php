<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateProductRequest extends FormRequest
{

//    protected $messages = [
//        'name.min' => 'Наименование должно содержать не менее 3х символов',
//        'name.unique' => 'Название уже существует',
//        'barcode.min' => 'Штрихкод должен содержать не менее 8 цифр',
//        'barcode.numeric' => 'Штрихкод должен содержать только циифры',
//        'opt_price.gte' => 'Розничная цена должна быть больше или равна оптовой цене.',
//    ];
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role === 'admin';
    }

    public function messages()
    {
        return [
            'name.min' => 'Наименование должно содержать не менее 3х символов',
            'name.unique' => 'Название уже существует',
            'barcode.min' => 'Штрихкод должен содержать не менее 8 цифр',
            'barcode' => 'Заполните поле Штрихкод',
            'barcode.numeric' => 'Штрихкод должен содержать только цифры',
            'price' => 'Заполните поле Розничная цена',
            'opt_price' => 'Заполните поле Оптовая цена',
            'price.numeric' => 'Розничная цена должна содержать только числа',
            'opt_price.numeric' => 'Оптовая цена должна содержать только числа',
            'quantity.numeric' => 'Количество может содержать только числа',
            'price.gt' => 'Розничная цена должна быть больше или равна оптовой цене.',
            'thumbnail' => 'Неверный формат файла.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|unique:products',
            'barcode' => 'required|string|min:8|numeric',
            'category_id' => 'required',
            'supplier' => 'required',
            'unit' => 'string',
            'price' => 'required|numeric|min:1|gt:opt_price',
            'opt_price' => 'required|numeric|min:1',
            'quantity' => 'required|numeric|min:0',
            'thumbnail' => 'image:jpeg,png,jpg',
        ];
    }
}
