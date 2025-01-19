<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
     * @return array<string => "",
     *  \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => "required|string",
            'second_name' => "required|string",
            'bussiness_name' => "nullable|string",
            'tax_no' => "nullable|string",
            'phone' => "required|string",
            'email' => "nullable|string",
            'start_date' => "required|date",
            'end_date' => "required|date",
            'url' => "nullable|string",
            'amount' => "required|numeric",
            'taxes' => "nullable|numeric",
            'discounts' => "nullable|numeric",
            'activity_id' => "required|numeric|exists:activities,id",
            'governorate_id' => "nullable|numeric",
            'package_id' => "required|numeric"
        ];
    }
}
