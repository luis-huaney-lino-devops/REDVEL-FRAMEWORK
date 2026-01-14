<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Persona
 *
 * @property int $idpersonas
 * @property string $dni
 * @property string $fotografia
 * @property Carbon $fecha_nacimiento
 * @property string $primer_apell
 * @property string $segundo_apell
 * @property string $nombres
 * @property int $fk_idgeneros
 *
 * @property Genero $genero
 * @property Collection|Empadronado[] $empadronados
 * @property Collection|Familiare[] $familiares
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Persona extends Model
{
    protected $connection = 'mysql';
    protected $table = 'personas';
    protected $primaryKey = 'idpersonas';
    public $timestamps = false;

    protected $casts = [
        'fecha_nacimiento' => 'datetime',
        'fk_idgeneros' => 'int'
    ];

    protected $fillable = [
        'dni',
        'fotografia',
        'fecha_nacimiento',
        'primer_apell',
        'segundo_apell',
        'nombres',
        'correo',
        'telefono',
        'direccion',
        'fk_idgeneros'
    ];

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'fk_idgeneros');
    }


    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'fk_idpersonas');
    }
}
