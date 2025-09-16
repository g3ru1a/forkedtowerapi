<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'character_id' => 'required|exists:characters,id',
            'class_id' => 'required|exists:f_f_classes,id',
            'registration_id' => 'exists:registrations,id',
            'phantom_job_id' => 'exists:phantom_jobs,id',
            'is_raidlead' => 'boolean',
            'is_helper' => 'boolean',
        ];
    }
}
