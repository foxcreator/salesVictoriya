<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateCategoryRequest extends FormRequest
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
            'name' => 'required|min:4|max:15|unique:categories'
        ];
    }

    public function messages()
    {
        return [
            'name' => 'Заполните поле, оно одно!!',
            'name.min' => 'Имя категории не может содержать менее 4 символов',
            'name.max' => 'Имя категории не может содержать более 15 символов',
            'name.unique' => 'Такая категория уже существует',
        ];
    }
}
