<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCollaborationRequest extends FormRequest
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
            'requested_id' => [
                'required',
                'integer',
                'exists:users,id',
                Rule::notIn([$this->user()->id]), // rule ini agar user tidak bisa mengirim permintaan kolaborasi ke dirinya sendiri
            ],
            'message' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'requested_id.not_in' => 'You cannot send a collaboration request to yourself.',
        ];
    }
}
