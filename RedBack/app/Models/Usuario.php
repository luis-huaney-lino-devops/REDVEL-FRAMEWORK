<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Usuario
 *
 * @property int $idusuarios
 * @property string $codigo_usuario
 * @property Carbon|null $email_verificado
 * @property int $estado
 * @property string $nomusu
 * @property string $password
 * @property string $tipo_autenticacion
 * @property string|null $provider_id
 * @property string|null $provider_token
 * @property Carbon $fecha_creacion
 * @property Carbon $fecha_ultimo_acceso
 * @property int $fk_id_personas
 * @property int $fk_id_empresas
 *
 * @property Empresa $empresa
 * @property Persona $persona
 * @property Collection|Accione[] $acciones
 * @property Collection|Archivo[] $archivos
 * @property Collection|Comunicado[] $comunicados
 * @property Collection|Notificacione[] $notificaciones
 * @property Collection|Proyecto[] $proyectos
 * @property Collection|Servicio[] $servicios
 * @property Collection|Sessione[] $sessiones
 *
 * @package App\Models
 */
class Usuario extends Authenticatable implements JWTSubject
{
    use HasRoles;
    use SoftDeletes;
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'usuarios';
    protected $primaryKey = 'idusuarios';
    protected $guard_name = 'api';
    public $timestamps = true;
    protected $softDeletes = true;
    protected $casts = [
        'email_verificado' => 'datetime',
        'estado' => 'int',
        'fecha_creacion' => 'datetime',
        'fecha_ultimo_acceso' => 'datetime',
        'fk_idpersonas' => 'int',
    ];

    protected $hidden = [
        'password',
        'provider_token'
    ];

    protected $fillable = [
        'codigo_usuario',
        'email_verificado',
        'estado',
        'nomusu',
        'password',
        'tipo_autenticacion',
        'provider_id',
        'provider_token',
        'fecha_creacion',
        'fecha_ultimo_acceso',
        'fk_idpersonas',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * IMPORTANTE: Solo incluir información mínima necesaria para la autenticación.
     * Los permisos NO deben incluirse aquí ya que:
     * 1. Pueden cambiar y el token seguiría siendo válido
     * 2. Pueden exceder límites de tamaño de cookies/headers
     * 3. No es seguro almacenar demasiados datos en el JWT
     * Los permisos deben obtenerse mediante el endpoint /user/permissions
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            // Solo información mínima necesaria
            'codigo_usuario' => $this->codigo_usuario,
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

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'fk_idpersonas');
    }


    public function sessiones()
    {
        return $this->hasMany(Sessione::class, 'fk_idusuarios');
    }
}
