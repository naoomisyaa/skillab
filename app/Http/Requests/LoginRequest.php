<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username'    => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            // username
            'username.required' => 'Please enter your username.',
            'username.string'   => 'Username must be a valid text.',

            // password
            'password.required' => 'Please enter your password.',
            'password.string'   => 'Password must be a valid text.',

            // remember
            'remember.boolean' => 'Invalid value for remember option.',
        ];
    }
}
