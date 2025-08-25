<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAssignmentRequest extends FormRequest
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
            'registration_id' => 'required|string|exists:registrations,id',
            'schedule_id' => 'required|string|exists:schedules,id',
            'user_id' => 'required|string|exists:users,id',
            'character_id' => 'required|string|exists:characters,id',
            'seat' => 'integer|required',
            'class' => 'string|required',
            'job' => 'string|required',
            'is_lead' => 'boolean',
            'is_absent' => 'boolean',
            'did_participate' => 'boolean',
        ];
    }
}
