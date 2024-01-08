<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DemandeAnnulationSauvegarderRequest extends FormRequest
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
        if($this->id_demande){
            return [
                'id_motif_demande_annulation_plan' => 'required',
                'commentaire_demande_annulation_plan' => 'required',
                'piece_demande_annulation_plan' => 'nullable|mimes:pdf,PDF,png,jpg,jpeg,PNG,JPG,JPEG|max:5120'
            ];
        }
        return [
            'id_motif_demande_annulation_plan' => 'required',
            'commentaire_demande_annulation_plan' => 'required',
            'piece_demande_annulation_plan' => 'required|mimes:pdf,PDF,png,jpg,jpeg,PNG,JPG,JPEG|max:5120'
        ];
    }

    public function message(): array
    {
        return [
            'id_motif_demande_annulation_plan.required' => 'Veuillez ajoutez le motif de la demande d\'annulation.',
            'commentaire_demande_annulation_plan.required' => 'Veuillez ajoutez le commentaire de la demande d\'annulation.',
            'piece_demande_annulation_plan.required' => 'Veuillez ajoutez la massse salariale.',
            'piece_demande_annulation_plan.mimes' => 'Les formats requises pour la proformat est: PDF,PNG,JPG,JPEG.',
            'piece_demande_annulation_plan.max'=> 'la taille maximale doit etre 5 MegaOctets.',
        ];
    }
}
