<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role == 'creator';
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
            'image' => 'required|image|max:10240|mimes:png,jpg,gif',
            'funding_goal' => 'required|numeric|min:100|integer',
            'deadline' => 'required|date|after:today',
            'full_desc' => 'required|string|max:2000',
            'tiers' => 'required|array|min:1',
            'tiers.*.amount' => 'required|numeric|min:1',
            'tiers.*.title' => 'required|string|max:20',
            'tiers.*.desc' => 'required|string|max:255'
        ];
    }
}
