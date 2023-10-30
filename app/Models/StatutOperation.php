<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_statut_operation
 * @property string $libelle_statut_operation
 * @property string $code_statut_operation
 * @property boolean $flag_statut_operation
 * @property string $updated_at
 * @property string $created_at
 * @property DemandeEnrolement[] $demandeEnrolements
 */
class StatutOperation extends Model 
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'statut_operation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_statut_operation';

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
    protected $fillable = ['libelle_statut_operation', 'code_statut_operation', 'flag_statut_operation', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeEnrolements()
    {
        return $this->hasMany('App\Models\DemandeEnrolement', 'id_statut_operation', 'id_statut_operation');
    }
}
