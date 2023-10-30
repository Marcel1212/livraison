<?php

namespace App\Models;

use App\ModelHasPermission;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $guard_name
 * @property string $lib_permission
 * @property string $created_at
 * @property string $updated_at
 * @property ModelHasPermission[] $modelHasPermissions
 * @property Role[] $roles
 * @property Sousmenus $sousmenu
 */
class Permissions extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['name','lib_permission','id_sousmenu','is_valide', 'guard_name', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modelHasPermissions()
    {
        return $this->hasMany('App\ModelHasPermission');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sousmenu()
    {
        return $this->belongsTo('App\Models\Sousmenus', 'id_sousmenu', 'id_sousmenu');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_has_permissions');
    }
}
