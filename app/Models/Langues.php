<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_langues
 * @property string $libelle_langues
 * @property string $code_langues
 * @property boolean $flag_langues
 * @property string $created_at
 * @property string $updated_at
 * @property LanguesFormateur[] $languesFormateurs
 */
class Langues extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_langues';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_langues', 'code_langues', 'flag_langues', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function languesFormateurs()
    {
        return $this->hasMany('App\Models\LanguesFormateur', 'id_langues', 'id_langues');
    }
}
