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
            'fight_id' => 'required|uuid|exists:fights,id',
            'public' =>  'required|boolean',
            'date'  => 'required|date_format:Y-m-d',
            'time'  => 'required|date_format:H:i',
            'description' => 'string|nullable',
            'seat_count' => 'integer|nullable|in:8,24,48',
            'registration_open' => 'required|boolean',
            'duration_hours' => 'nullable|integer|max:24|min:1',
            'type_id' => 'required|uuid|exists:run_types,id',
        ];
    }
}
