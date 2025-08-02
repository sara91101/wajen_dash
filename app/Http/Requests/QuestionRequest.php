<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            "name"=>['required', 'string', 'min:2'],
            "email"=>"required|email",
            'phone' => ['required', 'regex:/^05\d{8}$/'],
            "activity_name"=>"required|string",
            "town"=>"required|string",
            "contact_time"=>"required|string",
            "message"=>"required|string",
        ];
    }
}
