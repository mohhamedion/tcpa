<?php

namespace App\Http\Requests\TwilioSettings;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateCompanyTwilioSettings extends FormRequest
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
            'from_number' => ['required','string'],
            'sid' => ['required','string'],
            'token' => ['required','string'],
        ];
    }
}
