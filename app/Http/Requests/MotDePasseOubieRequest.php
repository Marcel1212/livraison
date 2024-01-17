<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MotDePasseOubieRequest extends FormRequest
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
            'email_mot_de_passe_oublie' => 'required|exists:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'email_mot_de_passe_oublie.required' => 'le champs E-mail est obligatoire',
            'email_mot_de_passe_oublie.exists' => 'L\'adresse e-mail que vous avez entré(e) n’existe pas. Vérifiez que vous avez correctement saisi votre adresse e-mail',
        ];
    }
}
