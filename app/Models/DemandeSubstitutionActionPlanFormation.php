<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeSubstitutionActionPlanFormation extends Model
{
    use HasFactory;
    protected $table ="demande_substi_action_formation";
    protected $primaryKey = 'id_substi_action_formation_plan';

    protected $fillable = [
//        'id_substi_action_formation_plan',
//        'id_action_formation_plan_a_substi',
//        'intitule_action_formation_plan_substi',
//        'structure_etablissement_action_substi',
//        'flag_soumis_demande_substitution_action_plan',
//        'date_soumis_demande_substitution_action_plan',
//        'nombre_stagiaire_action_formati_substi',
//        'nombre_groupe_action_formation_substi',
//        'nombre_heure_action_formation_p_substi',
//        'cout_action_formation_plan_substi',
//        'id_action_formation_plan_substi',
//        'id_plan_de_formation',
//        'id_user',
//        'created_at',
//        'updated_at',
//        'id_processus',
//        'numero_action_formation_plan_substi',
//        'facture_proforma_action_formati_substi',
//        'cout_accorde_action_formation__substi',
//        'commentaire_action_formation_substi',
//        'id_entreprise_structure_formation_action_substi',
//        'id_secteur_activite_substi',
//        'id_caracteristique_type_formation_substi',
//        'nombre_jour_action_formation_substi',
//        'montant_attribuable_fdfp_substi',
        'commentaire_demande_plan_substi',
        'piece_demande_plan_substi',
        'id_motif_demande_plan_substi'
    ];

    public function caracteristiqueTypeFormation()
    {
        return $this->belongsTo(CaracteristiqueTypeFormation::class, 'id_caracteristique_type_formation_substi', 'id_caracteristique_type_formation');
    }

    public function domaineFormation()
    {
        return $this->belongsTo(DomaineFormation::class, 'id_domaine_formation_substi', 'id_domaine_formation');
    }

}
