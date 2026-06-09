<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTravelPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check(); // Tylko zalogowani mogą zapisywać plany
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'dates' => 'nullable|string',
            'days' => 'required|json',
            'flight_data' => 'nullable|json',
            'hotel_data' => 'nullable|json',
        ];
    }
}
