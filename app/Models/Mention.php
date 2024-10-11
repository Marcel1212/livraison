<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_mention
 * @property string $libelle_mention
 * @property string $code_mention
 * @property boolean $flag_mention
 * @property string $created_at
 * @property string $updated_at
 * @property LanguesFormateur[] $languesFormateurs
 */
class Mention extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'mention';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_mention';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_mention', 'code_mention', 'flag_mention', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function languesFormateurs()
    {
        return $this->hasMany('App\Models\LanguesFormateur', 'id_mention', 'id_mention');
    }
}
