<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vivienda
 * 
 * @property int $idviviendas
 * @property string $codigo
 * @property int $num_miembros
 * @property int $num_hombres
 * @property int $num_mujeres
 * @property int $fk_idempadronados
 * @property int $fk_iddirecciones
 * 
 * @property Direccione $direccione
 * @property Empadronado $empadronado
 * @property Collection|CortesReconeccione[] $cortes_reconecciones
 *
 * @package App\Models
 */
class Vivienda extends Model
{
	protected $connection = 'mysql';
	protected $table = 'viviendas';
	protected $primaryKey = 'idviviendas';
	public $timestamps = false;

	protected $casts = [
		'num_miembros' => 'int',
		'num_hombres' => 'int',
		'num_mujeres' => 'int',
		'fk_idempadronados' => 'int',
		'fk_iddirecciones' => 'int'
	];

	protected $fillable = [
		'codigo',
		'num_miembros',
		'num_hombres',
		'num_mujeres',
		'fk_idempadronados',
		'fk_iddirecciones'
	];

	public function direccione()
	{
		return $this->belongsTo(Direccione::class, 'fk_iddirecciones');
	}

	public function empadronado()
	{
		return $this->belongsTo(Empadronado::class, 'fk_idempadronados');
	}

	public function cortes_reconecciones()
	{
		return $this->hasMany(CortesReconeccione::class, 'fk_idviviendas');
	}
}
