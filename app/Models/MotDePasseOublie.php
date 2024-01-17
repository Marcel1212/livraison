<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotDePasseOublie extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mot_de_passe_oublie';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_mot_de_passe_oublie';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

}
