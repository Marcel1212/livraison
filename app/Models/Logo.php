<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_logo
 * @property string $titre_logo
 * @property string $logo_logo
 * @property boolean $flag_logo
 * @property int $id_user
 * @property string $mot_cle
 * @property string $valeur
 * @property string $created_at
 * @property string $updated_at
 */
class Logo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logo';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_logo';

    /**
     * @var array
     */
    protected $fillable = ['titre_logo', 'logo_logo', 'flag_logo', 'id_user', 'mot_cle', 'valeur', 'created_at', 'updated_at'];

}
