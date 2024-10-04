<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_langues_formateurs
 * @property float $id_formateurs
 * @property float $id_aptitude
 * @property float $id_mention
 * @property float $id_langues
 * @property string $principale_qualification_libelle
 * @property boolean $flag_principale_qualification
 * @property string $created_at
 * @property string $updated_at
 * @property Aptitude $aptitude
 * @property Formateurs $formateurs
 * @property Langues $langues
 * @property Mention $mention
 */
class LanguesFormateurs extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_langues_formateurs';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_formateurs', 'id_aptitude', 'id_mention', 'id_langues', 'principale_qualification_libelle', 'flag_principale_qualification', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aptitude()
    {
        return $this->belongsTo('App\Models\Aptitude', 'id_aptitude', 'id_aptitude');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formateurs()
    {
        return $this->belongsTo('App\Models\Formateurs', 'id_formateurs', 'id_formateurs');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function langues()
    {
        return $this->belongsTo('App\Models\Langues', 'id_langues', 'id_langues');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mention()
    {
        return $this->belongsTo('App\Models\Mention', 'id_mention', 'id_mention');
    }
}
