<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorageMailRequest extends FormRequest
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
            'customerEmail'          => 'required|email',
            'materialName'          => 'required|string',
            'currentQuantity'           => 'required|integer',
            'unit'        => 'required|string',
            'depletionDate'    => 'nullable|date',
            'depletionPercentage'  => 'nullable|numeric',
            'customerName'                   => 'required|string',
            'reorderLevel'            => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'customerEmail.required' => 'Customer email is required.',
            'customerEmail.email' => 'Please enter a valid email address.',
            'materialName.required' => 'Material name is required.',
            'depletionPercentage.numeric' => 'Depletion percentage must be a number.',
        ];
    }

}
