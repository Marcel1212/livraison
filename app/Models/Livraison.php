<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_livraison
 * @property float $id_commune_exp
 * @property float $id_commune_dest
 * @property string $libelle_commune_exp
 * @property string $libelle_commune_dest
 * @property string $code_livraison
 * @property string $commentaire_livraison
 * @property float $prix
 * @property string $nom_exp
 * @property string $details_exp
 * @property string $nom_dest
 * @property string $details_dest
 * @property boolean $flag_a_traite
 * @property boolean $flag_en_attente
 * @property boolean $flag_liv_en_cours
 * @property boolean $flag_livre
 * @property boolean $flag_echec
 * @property boolean $flag_valide
 * @property float $id_livreur
 * @property float $id_gestionnaire
 * @property float $id_client
 * @property string $created_at
 * @property string $date_livraison_effectue
 * @property string $updated_at
 * @property Localite $localite
 * @property Localite $localite
 */
class Livraison extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'livraison';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_livraison';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_commune_exp', 'id_commune_dest', 'numero_dest', 'date_livraison', 'flag_valide', 'date_livraison_effectue' , 'numero_exp', 'libelle_commune_exp', 'libelle_commune_dest', 'code_livraison', 'prix', 'nom_exp', 'details_exp', 'commentaire_livraison', 'nom_dest', 'details_dest', 'flag_a_traite', 'flag_en_attente', 'flag_liv_en_cours', 'flag_livre', 'flag_echec', 'id_livreur', 'id_gestionnaire', 'id_client', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function localite()
    {
        return $this->belongsTo('App\Models\Localite', 'id_commune_dest', 'id_localite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function localitedest()
    {
        return $this->belongsTo('App\Models\Localite', 'id_commune_exp', 'id_localite');
    }
}
