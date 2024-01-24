<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
            'unitCost' => 'required|numeric|min:0',
            'sellingPrice' => 'required|numeric|min:0',
            'productId' => 'required|exists:products,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'quantity.required' => 'Quantity is required',
            'quantity.integer' => 'Quantity must be an integer',
            'quantity.min' => 'Quantity must be at least 1',
            'unitCost.required' => 'Unit cost is required',
            'unitCost.numeric' => 'Unit cost must be a number',
            'unitCost.min' => 'Unit cost must be at least 0',
            'sellingPrice.required' => 'Selling price is required',
            'sellingPrice.numeric' => 'Selling price must be a number',
            'sellingPrice.min' => 'Selling price must be at least 0',
            'productId.required' => 'Product ID is required',
            'productId.exists' => 'Product not found',
        ];
    }
}
