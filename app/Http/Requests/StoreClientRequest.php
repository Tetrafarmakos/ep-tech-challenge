<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    public function authorize()
    {
        // Authorization is handled by ClientsController authorizeResource
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:190'],
            'email'    => [
                'nullable',
                'required_without:phone',
                'email:rfc,dns',
                'max:190',
                Rule::unique('clients', 'email')->where(function ($q) {
                    return $q->where('user_id', $this->user()->id);
                }
                ),
            ],
            'phone'    => [
                'nullable',
                'required_without:email',
                'regex:/^[0-9 +]+$/',
                'max:30',
                Rule::unique('clients', 'phone')->where(function ($q) {
                    return $q->where('user_id', $this->user()->id);
                }
                ),
            ],
            'address'  => ['nullable', 'string', 'max:255'],
            'city'     => ['nullable', 'string', 'max:120'],
            'postcode' => ['nullable', 'string', 'max:30'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'The phone number may only contain digits, spaces, and the plus sign.',
            'email.required_without' => 'You must provide either an email or a phone number.',
            'phone.required_without' => 'You must provide either a phone number or an email.',
        ];
    }
}
