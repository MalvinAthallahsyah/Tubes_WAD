<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization will be handled by auth module.
        // For now, allow request.
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'], // Required for now
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'product_id' => [
                'nullable',
                Rule::requiredIf(fn () => !$this->input('seller_id')),
                'exists:products,id',
            ],
            'seller_id' => [
                'nullable',
                Rule::requiredIf(fn () => !$this->input('product_id')),
                'exists:sellers,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'A user ID is required for this review (temporary).',
            'user_id.exists' => 'The provided user ID does not exist.',
            'product_id.required_if' => 'Either a product or a seller reference is required.',
            'seller_id.required_if' => 'Either a product or a seller reference is required.',
        ];
    }
}