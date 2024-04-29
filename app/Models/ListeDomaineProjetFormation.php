<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_liste_domaine_projet_formation
 * @property float $id_projet_formation
 * @property float $id_domaine_formation
 * @property string $created_at
 * @property string $updated_at
 * @property Comite $comite
 * @property User $user
 */
class ListeDomaineProjetFormation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'liste_domaine_projet_formation';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_liste_domaine_projet_formation';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_projet_formation', 'id_domaine_formation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projetFormation()
    {
        return $this->belongsTo('App\Models\ProjetFormation', 'id_projet_formation', 'id_projet_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domaineFormation()
    {
        return $this->belongsTo('App\Models\DomaineProjetFormation', 'id_domaine_formation');
    }
}
