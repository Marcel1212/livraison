<?php

namespace App\Models;

use App\Sousmenu;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_menu
 * @property string $menu
 * @property string $created_at
 * @property string $updated_at
 * @property Sousmenu[] $sousmenus
 */
class Menus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_menu';

    /**
     * @var array
     */
    protected $fillable = ['menu','priorite_menu','is_valide' ,'icone' , 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sousmenus()
    {
        return $this->hasMany('App\Sousmenu', 'menu_id_menu', 'id_menu');
    }
}
