<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_beneficiaire_formation
 * @property float $id_fiche_agrement
 * @property string $nom_prenoms
 * @property string $genre
 * @property float $annee_naissance
 * @property string $nationalite
 * @property string $fonction
 * @property string $categorie
 * @property float $annee_embauche
 * @property string $matricule_cnps
 * @property FicheADemandeAgrement $ficheADemandeAgrement
 */
class BeneficiairesFormation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'beneficiaires_formation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_beneficiaire_formation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_fiche_agrement', 'nom_prenoms', 'genre', 'annee_naissance', 'nationalite', 'fonction', 'categorie', 'annee_embauche', 'matricule_cnps'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ficheADemandeAgrement()
    {
        return $this->belongsTo('App\Models\FicheADemandeAgrement', 'id_fiche_agrement', 'id_fiche_agrement');
    }
}
