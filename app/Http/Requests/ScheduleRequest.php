<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'group_id' => 'required|uuid|exists:groups,id',
            'host_id' => 'required|uuid|exists:characters,id',
            'public' =>  'required|boolean',
            'date'  => 'required|date_format:Y-m-d',
            'time'  => 'required|date_format:H:i',
            'description' => 'string|nullable',
            'slots' => 'integer|nullable|in:8,24,48',
            'registration_open' => 'required|boolean',
            'registration_deadline' => 'nullable|date_format:Y-m-d H:i',
            'type_id' => 'required|uuid|exists:run_types,id',
        ];
    }
}
