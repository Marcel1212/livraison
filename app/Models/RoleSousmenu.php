<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_sousmenu
 * @property integer $role_id
 */
class RoleSousmenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role_sousmenu';

    /**
     * @var array
     */
    protected $fillable = ['id_sousmenu', 'role_id'];

}
