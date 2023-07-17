<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        $productId = $this->route('id'); // Получаем ID текущего продукта из маршрута

        return [
            'name' => ['required', 'string', 'min:3', Rule::unique('products')->ignore($productId)],
            'barcode' => ['required', 'string', 'min:8'],
            'supplier' => ['required'],
            'price' => ['required', 'numeric', 'min:1'],
            'thumbnail' => ['nullable', 'image:jpeg,png,jpg'],
        ];
    }

}
