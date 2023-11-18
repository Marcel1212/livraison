<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_parcours
 * @property float $id_processus
 * @property float $id_user
 * @property float $id_piece
 * @property float $id_roles
 * @property float $num_agce
 * @property string $comment_parcours
 * @property boolean $is_valide
 * @property string $date_valide
 * @property boolean $is_annule
 * @property string $date_annule
 * @property string $created_at
 * @property string $updated_at
 */
class Parcours extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_parcours';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_processus', 'id_user', 'id_piece', 'id_roles', 'num_agce', 'comment_parcours',
        'is_valide', 'date_valide', 'is_annule', 'date_annule', 'created_at', 'updated_at','id_combi_proc'];

}
