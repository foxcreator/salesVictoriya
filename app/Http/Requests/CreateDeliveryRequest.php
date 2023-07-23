<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\RetailPriceGreaterThanPurchasePrice;


class CreateDeliveryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function messages()
    {
        return [
            'products' => 'Выберите хотябы один продукт',
            'quantity' => 'Укажите количество продуктов в поставке!',
            'quantity.*' => 'Используйте только числа для указания количества',
            'purchase_price' => 'Введите цену закупки!',
            'purchase_price.*' => 'Цена закупки указана неверно! Только числа не меньше 1!',
            'retail_price' => 'Введите розничную цену!',
            'retail_price.*' => 'Розничная цена указана неверно! Только числа не меньше 1!',
            'retail_price.*.gt' => 'Цена продажи не может быть меньше цены покупки.'


        ];
    }


// ...

    public function rules()
    {
        $rules = [
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
        ];

        foreach ($this->input('products', []) as $productId) {
            $rules['quantity.' . $productId] = 'required|numeric';
            $rules['purchase_price.' . $productId] = 'required|numeric|min:1';
            $rules['retail_price.' . $productId] = [
                'required',
                'numeric',
                'min:1',
                new RetailPriceGreaterThanPurchasePrice($productId), // Используем кастомное правило
            ];
        }

        return $rules;
    }


}
