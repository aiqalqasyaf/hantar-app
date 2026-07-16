<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
            'company' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'status' => 'required|in:applied,interview,offer,rejected',
            'applied_at' => 'required|date',
            'job_url' => 'nullable|url|max:255',
            'job_description' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'company.required' => 'Please enter the company name.',
            'role.required' => 'Please enter the role you applied for.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Please select a valid status.',
            'applied_at.required' => 'Please select the date you applied.',
            'applied_at.date' => 'Please enter a valid date.',
            'job_url.url' => 'Please enter a valid URL (starting with http:// or https://).',
        ];
    }
}
