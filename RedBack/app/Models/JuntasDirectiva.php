<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JuntasDirectiva
 * 
 * @property int $idjuntas_directivas
 * @property Carbon $fech_inicio
 * @property Carbon $fech_fin
 * @property int $fk_idcargo
 * @property int $fk_idempadronados
 * 
 * @property Cargo $cargo
 * @property Empadronado $empadronado
 * @property Collection|DetalleEgreso[] $detalle_egresos
 * @property Collection|DetalleInventario[] $detalle_inventarios
 *
 * @package App\Models
 */
class JuntasDirectiva extends Model
{
	protected $connection = 'mysql';
	protected $table = 'juntas_directivas';
	protected $primaryKey = 'idjuntas_directivas';
	public $timestamps = false;

	protected $casts = [
		'fech_inicio' => 'datetime',
		'fech_fin' => 'datetime',
		'fk_idcargo' => 'int',
		'fk_idempadronados' => 'int'
	];

	protected $fillable = [
		'fech_inicio',
		'fech_fin',
		'fk_idcargo',
		'fk_idempadronados'
	];

	public function cargo()
	{
		return $this->belongsTo(Cargo::class, 'fk_idcargo');
	}

	public function empadronado()
	{
		return $this->belongsTo(Empadronado::class, 'fk_idempadronados');
	}

	public function detalle_egresos()
	{
		return $this->hasMany(DetalleEgreso::class, 'fk_idjuntas_directivas');
	}

	public function detalle_inventarios()
	{
		return $this->hasMany(DetalleInventario::class, 'fk_idjuntas_directivas');
	}
}
