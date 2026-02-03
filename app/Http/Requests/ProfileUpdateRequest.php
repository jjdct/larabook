<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            // Validamos los nombres por separado
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
        
            // El username debe ser único, pero ignoramos mi propio ID para que no de error si no lo cambio
            'username'   => ['required', 'string', 'max:50', \Illuminate\Validation\Rule::unique('users')->ignore($this->user()->id)],
        
            // Email igual, ignorando el propio ID
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($this->user()->id)],
        
            // La bio es opcional
            'bio'        => ['nullable', 'string', 'max:500'],
        ];
    }
}
