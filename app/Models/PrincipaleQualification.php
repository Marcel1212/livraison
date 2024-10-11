<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_principale_qualification
 * @property float $id_formateurs
 * @property string $principale_qualification_libelle
 * @property boolean $flag_principale_qualification
 * @property string $created_at
 * @property string $updated_at
 * @property Formateur $formateur
 */
class PrincipaleQualification extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'principale_qualification';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_principale_qualification';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_formateurs', 'principale_qualification_libelle', 'flag_principale_qualification', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formateur()
    {
        return $this->belongsTo('App\Models\Formateur', 'id_formateurs', 'id_formateurs');
    }
}
