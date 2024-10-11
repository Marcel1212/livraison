<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_commentaire_non_recevable_demande
 * @property float $id_motif_recevable
 * @property string $commentaire_commentaire_non_recevable_demande
 * @property float $id_demande
 * @property string $code_demande
 * @property boolean $flag_commentaire_non_recevable_demande
 * @property string $created_at
 * @property string $updated_at
 * @property Motif $motif
 */
class CommentaireNonRecevableDemande extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'commentaire_non_recevable_demande';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_commentaire_non_recevable_demande';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_motif_recevable', 'commentaire_commentaire_non_recevable_demande', 'id_demande', 'code_demande', 'flag_commentaire_non_recevable_demande', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motif()
    {
        return $this->belongsTo('App\Models\Motif', 'id_motif_recevable', 'id_motif');
    }
}
