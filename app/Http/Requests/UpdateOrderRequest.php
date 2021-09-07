<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape([
        'phone' => "string",
        'client_name' => "string",
        'address' => "string",
        'orderItems' => "string",
        'orderItems.*.product_id' => "string",
        'orderItems.*.quantity' => "string"
    ])]
    public function rules(): array
    {
        return [
            'phone' => 'string',
            'client_name' => 'string',
            'address' => 'string',
            'orderItems' => 'array',
            'orderItems.*.product_id' => 'required|integer|exists:products,id',
            'orderItems.*.quantity' => 'required|integer|min:1',
        ];
    }
}
