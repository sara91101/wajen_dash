<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FreeTrialRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'min:2'],
            'second_name' => ['required', 'string', 'min:2'],
            'bussiness_name' => "nullable|string",
            'tax_no' => ['nullable', 'regex:/^3\d{14}$/'],
            'phone' =>['required', 'regex:/^05\d{8}$/'],
            'email' => "required|email",
            'town' => "required|numeric",
            'activity_type' => ['required', 'integer', 'in:2,3'],
            'password' => ['required', 'digits:6'],
            'registeration_no' => "nullable|string",

            'branches_number' => "nullable|string",
            'use_casheir' => ['nullable', 'string', 'in:Yes,No'], 
            'change_reason' => "nullable|string", 
            'service' => "nullable|numeric", 
            'contact_time' => "nullable|string"

        ];
    }
}
