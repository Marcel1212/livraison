<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_aptitude
 * @property string $libelle_aptitude
 * @property string $code_aptitude
 * @property boolean $flag_aptitude
 * @property string $created_at
 * @property string $updated_at
 * @property LanguesFormateur[] $languesFormateurs
 */
class Aptitude extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'aptitude';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_aptitude';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_aptitude', 'code_aptitude', 'flag_aptitude', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function languesFormateurs()
    {
        return $this->hasMany('App\Models\LanguesFormateur', 'id_aptitude', 'id_aptitude');
    }
}
