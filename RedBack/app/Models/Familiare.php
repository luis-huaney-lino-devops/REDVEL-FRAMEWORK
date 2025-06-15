<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Familiare
 * 
 * @property int $idfamiliares
 * @property Carbon $fecha_reg
 * @property int $fk_idpersonas
 * @property int $fk_idactividad
 * @property int $fk_idtipo_familiares
 * @property int $fk_idempadronados
 * 
 * @property Actividad $actividad
 * @property Empadronado $empadronado
 * @property Persona $persona
 * @property TipoFamiliare $tipo_familiare
 *
 * @package App\Models
 */
class Familiare extends Model
{
	protected $connection = 'mysql';
	protected $table = 'familiares';
	protected $primaryKey = 'idfamiliares';
	public $timestamps = false;

	protected $casts = [
		'fecha_reg' => 'datetime',
		'fk_idpersonas' => 'int',
		'fk_idactividad' => 'int',
		'fk_idtipo_familiares' => 'int',
		'fk_idempadronados' => 'int'
	];

	protected $fillable = [
		'fecha_reg',
		'fk_idpersonas',
		'fk_idactividad',
		'fk_idtipo_familiares',
		'fk_idempadronados'
	];

	public function actividad()
	{
		return $this->belongsTo(Actividad::class, 'fk_idactividad');
	}

	public function empadronado()
	{
		return $this->belongsTo(Empadronado::class, 'fk_idempadronados');
	}

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'fk_idpersonas');
	}

	public function tipo_familiare()
	{
		return $this->belongsTo(TipoFamiliare::class, 'fk_idtipo_familiares');
	}
}
