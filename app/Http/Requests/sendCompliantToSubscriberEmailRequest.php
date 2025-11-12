<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sendCompliantToSubscriberEmailRequest extends FormRequest
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
            'subscriberEmail'   => 'required|email',
            'senderName'        => 'required|string',
            'senderPhoneNumber' => 'required|string',
            'messageType'       => 'required|integer',
            'message'           => 'required|string',
            'businessName'      => 'required|string',
            'branchName'        => 'nullable|string',
        ];
    }

    /**
     * Custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'subscriberEmail.required'   => 'The subscriber email is required.',
            'subscriberEmail.email'      => 'Please enter a valid email address.',

            'senderName.required'        => 'Your name is required.',
            'senderName.string'          => 'Your name must be a valid text.',

            'senderPhoneNumber.required' => 'Your phone number is required.',
            'senderPhoneNumber.string'   => 'Your phone number must be a valid string.',

            'messageType.required'       => 'Please select a message type.',
            'messageType.integer'        => 'The message type must be a valid number.',

            'message.required'           => 'Please enter your message.',
            'message.string'             => 'The message must be text.',

            'businessName.required'      => 'The business name is required.',
            'businessName.string'        => 'The business name must be text.',

            'branchName.required'      => 'The branch name is required.',
            'branchName.string'        => 'The business name must be text.',
        ];
    }
}
