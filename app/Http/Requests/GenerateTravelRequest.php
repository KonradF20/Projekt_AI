<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateTravelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Każdy (nawet niezalogowany) może kliknąć "szukaj", bo po chwili i tak przekieruje go do logowania z poziomu kontrolera
    }

    public function rules(): array
    {
        return [
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'dates' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'origin.required' => 'Wybierz miejsce wylotu.',
            'destination.required' => 'Wybierz cel podróży.',
            'dates.required' => 'Wybierz termin podróży.',
        ];
    }
}
