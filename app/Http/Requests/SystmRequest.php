<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystmRequest extends FormRequest
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
            "system_name_ar"=>"required|string",
            "system_name_en"=>"nullable|string",
            "url"=>"nullable|string",
            "endPoint_url"=>"nullable|string",
        ];
    }
}
