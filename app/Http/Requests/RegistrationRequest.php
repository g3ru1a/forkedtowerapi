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
            'schedule_secret' => 'string|nullable',
            'character_id' => 'required|exists:characters,id',
            'preferred_class_id' => 'required|exists:f_f_classes,id',
            'preferred_job_id' => 'required|exists:phantom_jobs,id',
            'flex_classes' => 'array',
            'flex_jobs' => 'array',
            'flex_classes.*' => 'exists:f_f_classes,id',
            'flex_jobs.*' => 'exists:phantom_jobs,id',
            'can_solo_heal'=> 'required|boolean',
            'can_english'=> 'required|boolean',
            'can_markers'=> 'required|boolean',
            'notes' => 'nullable|string',
        ];
    }
}
