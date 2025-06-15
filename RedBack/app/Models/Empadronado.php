<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Empadronado
 * 
 * @property int $idempadronados
 * @property bool $estado_empadronado
 * @property bool $empadronado_nuevo
 * @property Carbon $fecha_registro
 * @property string $telf
 * @property int $fk_idpersonas
 * @property int $fk_iddistritos
 * @property int $fk_idactividad
 * @property int $fk_idprofesiones
 * @property int $fk_idestado_civiles
 * @property int $fk_idgrado_instrucciones
 * 
 * @property Actividad $actividad
 * @property Distrito $distrito
 * @property EstadoCivile $estado_civile
 * @property GradoInstruccione $grado_instruccione
 * @property Persona $persona
 * @property Profesione $profesione
 * @property Collection|CambioTitular[] $cambio_titulars
 * @property Collection|DetallePago[] $detalle_pagos
 * @property Collection|Familiare[] $familiares
 * @property Collection|JuntasDirectiva[] $juntas_directivas
 * @property Collection|ReunionesPaticipacione[] $reuniones_paticipaciones
 * @property Collection|Vivienda[] $viviendas
 *
 * @package App\Models
 */
class Empadronado extends Model
{
	protected $connection = 'mysql';
	protected $table = 'empadronados';
	protected $primaryKey = 'idempadronados';
	public $timestamps = false;

	protected $casts = [
		'estado_empadronado' => 'bool',
		'empadronado_nuevo' => 'bool',
		'fecha_registro' => 'datetime',
		'fk_idpersonas' => 'int',
		'fk_iddistritos' => 'int',
		'fk_idactividad' => 'int',
		'fk_idprofesiones' => 'int',
		'fk_idestado_civiles' => 'int',
		'fk_idgrado_instrucciones' => 'int'
	];

	protected $fillable = [
		'estado_empadronado',
		'empadronado_nuevo',
		'fecha_registro',
		'telf',
		'fk_idpersonas',
		'fk_iddistritos',
		'fk_idactividad',
		'fk_idprofesiones',
		'fk_idestado_civiles',
		'fk_idgrado_instrucciones'
	];

	public function actividad()
	{
		return $this->belongsTo(Actividad::class, 'fk_idactividad');
	}

	public function distrito()
	{
		return $this->belongsTo(Distrito::class, 'fk_iddistritos');
	}

	public function estado_civile()
	{
		return $this->belongsTo(EstadoCivile::class, 'fk_idestado_civiles');
	}

	public function grado_instruccione()
	{
		return $this->belongsTo(GradoInstruccione::class, 'fk_idgrado_instrucciones');
	}

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'fk_idpersonas');
	}

	public function profesione()
	{
		return $this->belongsTo(Profesione::class, 'fk_idprofesiones');
	}

	public function cambio_titulars()
	{
		return $this->hasMany(CambioTitular::class, 'fk_idempadronados');
	}

	public function detalle_pagos()
	{
		return $this->hasMany(DetallePago::class, 'fk_idempadronados');
	}

	public function familiares()
	{
		return $this->hasMany(Familiare::class, 'fk_idempadronados');
	}

	public function juntas_directivas()
	{
		return $this->hasMany(JuntasDirectiva::class, 'fk_idempadronados');
	}

	public function reuniones_paticipaciones()
	{
		return $this->hasMany(ReunionesPaticipacione::class, 'fk_idempadronados');
	}

	public function viviendas()
	{
		return $this->hasMany(Vivienda::class, 'fk_idempadronados');
	}
}
