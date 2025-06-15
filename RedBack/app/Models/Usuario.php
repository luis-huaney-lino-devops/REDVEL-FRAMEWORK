<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Usuario
 *
 * @property int $idusuarios
 * @property string $codigo_usuario
 * @property bool $estado
 * @property string $nomusu
 * @property string $correo
 * @property string $password
 * @property int $fk_idpersonas
 *
 * @property Persona $persona
 *
 * @package App\Models
 */
class Usuario extends Authenticatable implements JWTSubject
{
    use HasRoles;
    protected $connection = 'mysql';
    protected $table = 'usuarios';
    protected $primaryKey = 'idusuarios';
    public $timestamps = false;

    protected $casts = [
        'estado' => 'bool',
        'fk_idpersonas' => 'int'
    ];

    protected $hidden = [
        'password'
    ];

    protected $fillable = [
        'codigo_usuario',
        'estado',
        'nomusu',
        'password',
        'fk_idpersonas'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'fk_idpersonas');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getAllPermissions()->pluck('name'),
        ];
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'idusuarios';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->idusuarios;
    }
}
