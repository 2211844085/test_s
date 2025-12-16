<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'username' => 'required|string|max:255',
            'current_password' => 'required_with:password|current_password',
            'password' => 'nullable|string|min:8|confirmed'
        ];
    }

    protected function prepareForValidation()
    {
        $filtered = array_filter($this->all(), function ($value) {
            return !is_null($value) && $value !== '';
        });

        $this->replace($filtered);
    }
}
