<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Każdy może spróbować się zarejestrować
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Pole imię i nazwisko jest wymagane.',
            'email.required' => 'Pole adres e-mail jest wymagane.',
            'email.email' => 'Podaj poprawny adres e-mail.',
            'email.unique' => 'Taki adres e-mail jest już zajęty.',
            'password.required' => 'Pole hasło jest wymagane.',
            'password.min' => 'Hasło musi mieć co najmniej 8 znaków.',
        ];
    }

    // Ta funkcja zadba o to, żeby w razie błędu odesłać JSON
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ], 422));
    }
}
