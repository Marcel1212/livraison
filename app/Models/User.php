<?php

namespace App\Models;

use App\Models\Agence;
use App\Models\Direction;
use App\Models\Departement;
use App\Models\Service;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
* @property Agence $agence
*/
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'prenom_users', 'email', 'password', 'genre_users', 'cel_users','login_users',
        'tel_users', 'localisation_users', 'adresse_users','id_partenaire','flag_mdp','flag_actif_users',
        'photo_profil','indicatif_cel_users','indicatif_tel_users','num_agce','email_agce','id_direction','id_departement','id_service'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agence()
    {
        return $this->belongsTo(Agence::class,'num_agce','num_agce');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function direction()
    {
        return $this->belongsTo(Direction::class,'id_direction','id_direction');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class,'id_departement','id_departement');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class,'id_service','id_service');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
