<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RenewPackageRequest extends FormRequest
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
            'membership_no'          => 'required|string',
            'invoice_date'           => 'required|date',
            'subscriber_name'        => 'required|string',
            'subscriber_phone_no'    => 'required|string',
            'subscriber_tax_number'  => 'required|string',
            'item'                   => 'required|string',
            'description'            => 'nullable|string',
            'quantity'               => 'required|numeric',
            'discount'               => 'required|numeric',
            'price'                  => 'required|numeric',
            'sum_before_tax'         => 'required|numeric',
            'tax_percentage'         => 'required|numeric',
            'tax_value'              => 'required|numeric',
            'sum_after_tax'          => 'required|numeric',
            'subscription_start_date'=> 'required|date',
            'subscription_end_date'  => 'required|date',
        ];
    }

    /**
     * Custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'membership_no.required'           => 'Membership number is required.',
            'membership_no.string'             => 'Membership number must be a valid string.',

            'invoice_date.required'            => 'Invoice date is required.',
            'invoice_date.date'                => 'Invoice date must be a valid date.',

            'subscriber_name.required'         => 'Subscriber name is required.',
            'subscriber_name.string'           => 'Subscriber name must be text.',

            'subscriber_phone_no.required'     => 'Subscriber phone number is required.',
            'subscriber_phone_no.string'       => 'Subscriber phone number must be text.',

            'subscriber_tax_number.required'   => 'Subscriber tax number is required.',
            'subscriber_tax_number.string'     => 'Subscriber tax number must be text.',

            'item.required'                    => 'Item is required.',
            'item.string'                      => 'Item must be text.',

            'description.string'               => 'Description must be text.',

            'quantity.required'                => 'Quantity is required.',
            'quantity.numeric'                 => 'Quantity must be a number.',

            'discount.required'                => 'Discount is required.',
            'discount.numeric'                 => 'Discount must be a valid number.',

            'price.required'                   => 'Price is required.',
            'price.numeric'                    => 'Price must be a valid number.',

            'sum_before_tax.required'          => 'Sum before tax is required.',
            'sum_before_tax.numeric'           => 'Sum before tax must be a valid number.',

            'tax_percentage.required'          => 'Tax percentage is required.',
            'tax_percentage.numeric'           => 'Tax percentage must be a valid number.',

            'tax_value.required'               => 'Tax value is required.',
            'tax_value.numeric'                => 'Tax value must be a valid number.',

            'sum_after_tax.required'           => 'Sum after tax is required.',
            'sum_after_tax.numeric'            => 'Sum after tax must be a valid number.',

            'subscription_start_date.required' => 'Subscription start date is required.',
            'subscription_start_date.date'     => 'Subscription start date must be a valid date.',

            'subscription_end_date.required'   => 'Subscription end date is required.',
            'subscription_end_date.date'       => 'Subscription end date must be a valid date.',
        ];
    }
}
