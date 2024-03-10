<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelSubscriptionRequest extends FormRequest
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
        $paymentMethods = config('payments.payment_methods');
        return [
            'paymentMethod' => 'required|in:' . implode(',', $paymentMethods),
            'reason' => 'required|string'
        ];
    }
    public function messages(): array
    {
        $paymentMethods = config('payments.payment_methods');
        $methodsString = implode(', ', $paymentMethods);

        return [
            'paymentMethod.in' => __("The selected payment method is invalid. Accepted values are: {$methodsString}."),
        ];
    }
}
