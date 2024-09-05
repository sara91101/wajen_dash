<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfoRequest extends FormRequest
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
     * @return array<string=>"",
     * \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_en'=>"required|string",
            'name_ar'=>"required|string",
            'logo'=>"nullable|mimes:png,jpg,jpeg",
            'bill'=>"nullable|mimes:png,jpg,jpeg",
            'phone'=>"required|string",
            'email'=>"required|email",
            'address_ar'=>"required|string",
            'address_en'=>"required|string"
        ];
    }
}
