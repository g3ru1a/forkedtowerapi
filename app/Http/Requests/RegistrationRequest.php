<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'schedule_id' => 'required|exists:schedules,id',
            'character_id' => 'required|exists:characters,id',
            'preferred_class' => 'required|string',
            'preferred_job' => 'required|string',
            'flex_classes' => 'required|array',
            'flex_jobs' => 'required|array',
            'flex_classes.*' => 'required|string',
            'flex_jobs.*' => 'required|string',
            'can_lead' => 'required|boolean',
            'notes' => 'nullable|string',
        ];
    }
}
