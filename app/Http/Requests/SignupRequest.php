<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El Nombre es Obligatorio',
            'email.required' => 'El E-mail es Obligatorio',
            'email.email' => 'E-mail no Valido',
            'email.unique' => 'El E-mail ya está en uso',
            'password.required' => 'La Contraseña es Obligatoria',
            'password.confirmed' => 'Las Contraseñas no Coinciden',
            'password.min' => 'La Contraseña debe tener al menos :min caracteres',
            'password.mixed' => 'La Contraseña debe tener mayúsculas y minúsculas',
            'password.symbols' => 'La Contraseña debe tener al menos 1 caracter especial',
            'password.numbers' => 'La Contraseña debe tener números',
            'password.uncompromised' => 'Elige una contraseña mas fuerte',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'], 
            'email' => ['required', 'email', 'unique:users,email'], 
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }
}
// ->mixedCase()->symbols()->numbers()->uncompromised()