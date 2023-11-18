<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_combi_proc
 * @property float $id_cont_agce
 * @property integer $id_sousmenu
 * @property integer $id_roles
 * @property float $priorite_combi_proc
 * @property boolean $is_valide
 * @property string $created_at
 * @property string $updated_at
 * @property ContenirAgence $contenirAgence
 * @property Sousmenu $sousmenu
 * @property Role $role
 */
class CombinaisonProcessus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'combinaison_processus';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_combi_proc';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_cont_agce', 'id_sousmenu', 'id_roles', 'id_processus','priorite_combi_proc',
        'is_valide', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contenirAgence()
    {
        return $this->belongsTo('App\Models\ContenirAgence', 'id_cont_agce', 'id_cont_agce');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sousmenu()
    {
        return $this->belongsTo('App\Models\Sousmenu', 'id_sousmenu', 'id_sousmenu');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'id_roles');
    }
}
