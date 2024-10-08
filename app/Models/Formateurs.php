<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_formateurs
 * @property float $id_entreprises
 * @property float $id_pays
 * @property string $nom_formateurs
 * @property string $prenom_formateurs
 * @property string $contact_formateurs
 * @property string $contact2_formateurs
 * @property string $email_formateurs
 * @property string $fonction_formateurs
 * @property string $date_de_naissance
 * @property string $date_de_recrutement
 * @property float $anciennete_emploi
 * @property boolean $flag_formateurs
 * @property boolean $flag_attestation_formateurs
 * @property string $created_at
 * @property string $updated_at
 * @property string $numero_matricule_fdfp
 * @property LanguesFormateurs[] $languesFormateurs
 * @property PrincipaleQualification[] $principaleQualifications
 * @property FormationsEduc[] $formationsEducs
 * @property Entreprises $entreprise
 * @property Pays $pay
 * @property FormateurDomaineDemandeHabilitation[] $formateurDomaineDemandeHabilitations
 * @property Competences[] $competences
 * @property Experiences[] $experiences
 * @property PiecesFormateur[] $piecesFormateurs
 */
class Formateurs extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_formateurs';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_entreprises', 'id_pays', 'nom_formateurs', 'prenom_formateurs', 'contact_formateurs', 'contact2_formateurs', 'email_formateurs', 'fonction_formateurs', 'date_de_naissance', 'date_de_recrutement', 'anciennete_emploi', 'flag_formateurs', 'flag_attestation_formateurs', 'created_at', 'updated_at', 'numero_matricule_fdfp'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function languesFormateurs()
    {
        return $this->hasMany('App\Models\LanguesFormateurs', 'id_formateurs', 'id_formateurs');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function principaleQualifications()
    {
        return $this->hasMany('App\Models\PrincipaleQualification', 'id_formateurs', 'id_formateurs');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formationsEducs()
    {
        return $this->hasMany('App\Models\FormationsEduc', 'id_formateurs', 'id_formateurs');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprises', 'id_entreprises', 'id_entreprises');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pay()
    {
        return $this->belongsTo('App\Models\Pays', 'id_pays', 'id_pays');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formateurDomaineDemandeHabilitations()
    {
        return $this->hasMany('App\Models\FormateurDomaineDemandeHabilitation', 'id_formateurs', 'id_formateurs');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function competences()
    {
        return $this->hasMany('App\Models\Competences', 'id_formateurs', 'id_formateurs');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function experiences()
    {
        return $this->hasMany('App\Models\Experiences', 'id_formateurs', 'id_formateurs');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function piecesFormateurs()
    {
        return $this->hasMany('App\Models\PiecesFormateur', 'id_formateurs', 'id_formateurs');
    }
}
