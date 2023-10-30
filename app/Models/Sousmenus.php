<?php

namespace App\Models;

use App\Menu;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_sousmenu
 * @property int $menu_id_menu
 * @property string $sousmenu
 * @property string $libelle
 * @property string $created_at
 * @property string $updated_at
 * @property Menu $menu
 */
class Sousmenus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sousmenu';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_sousmenu';

    /**
     * @var array
     */
    protected $fillable = ['menu_id_menu','sousmenu', 'libelle','priorite_sousmenu', 'is_valide' ,'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo('App\Menu', 'menu_id_menu', 'id_menu');
    }


     /**
     * The roles that belong to the user.
     */
    public function roless()
    {
        return $this->belongsToMany('App\Models\Role', 'role_has_sousmenus');
    }
}
