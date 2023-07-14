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


        return [
            'name' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string', 'min:10'],
            'price' => ['required', 'numeric', 'min:1'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'thumbnail' => ['nullable', 'image:jpeg,png,jpg'],
        ];
    }
}
