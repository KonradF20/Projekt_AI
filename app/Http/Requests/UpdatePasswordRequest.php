<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check(); // Tylko zalogowani mogą zmienić hasło
    }

    public function rules(): array
    {
        return [
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.current_password' => 'Obecne hasło jest nieprawidłowe.',
            'password.confirmed' => 'Hasła nie pasują do siebie.',
            'password.min' => 'Nowe hasło musi mieć co najmniej 8 znaków.'
        ];
    }
}
