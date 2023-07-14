<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateProductRequest extends FormRequest
{

    protected $messages = [
    'name.min' => 'We need to know your email address!',
    ];
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
        return [
            'name' => ['required', 'string', 'min:3', 'unique:products'],
            'barcode' => ['required', 'string', 'min:8'],
            'unit' => ['string'],
            'price' => ['required', 'numeric', 'min:1'],
            'opt_price' => ['required', 'numeric', 'min:1'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'thumbnail' => ['image:jpeg,png,jpg'],
        ];
    }
}
