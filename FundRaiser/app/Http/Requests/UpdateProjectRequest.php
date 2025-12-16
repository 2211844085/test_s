<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'title' => 'required|string',
            'tags' => 'required|array|max:5|min:1',
            'tags.*' => 'string',
            'short_desc' => 'required|string|max:150',
            'image' => 'nullable|image|max:10240|mimes:png,jpg,gif',
            'full_desc' => 'required|string|max:2000',
            'tiers' => 'required|array|min:1',
            'tiers.*.id' => 'exists:tiers,id',
            'tiers.*.amount' => 'required|numeric|min:1',
            'tiers.*.title' => 'required|string|max:20',
            'tiers.*.desc' => 'required|string|max:255'
        ];
    }
}
