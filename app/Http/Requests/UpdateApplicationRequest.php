<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationRequest extends FormRequest
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
}
