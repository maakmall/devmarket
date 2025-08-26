<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                Rule::requiredIf(fn() => $this->routeIs('products.store')),
                'max:255'
            ],
            'description' => [
                Rule::requiredIf(fn() => $this->routeIs('products.store'))
            ],
            'price' => [
                Rule::requiredIf(fn() => $this->routeIs('products.store')),
                'integer',
                'min:0'
            ],
            'category_id' => [
                Rule::requiredIf(fn() => $this->routeIs('products.store')),
                Rule::exists('categories', 'id')
            ],
            'file' => [
                Rule::requiredIf(fn() => $this->routeIs('products.store')),
                'file'
            ],
            'image' => [
                Rule::requiredIf(fn() => $this->routeIs('products.store')),
                'image',
                'max:2048'
            ]
        ];
    }
}
