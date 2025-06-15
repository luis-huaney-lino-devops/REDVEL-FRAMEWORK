<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FrecuenciasPago
 * 
 * @property int $idfrecuencias_pagos
 * @property string $nom_frecuencia
 * @property int $cantidad_mes
 * 
 * @property Collection|DetallePago[] $detalle_pagos
 *
 * @package App\Models
 */
class FrecuenciasPago extends Model
{
	protected $connection = 'mysql';
	protected $table = 'frecuencias_pagos';
	protected $primaryKey = 'idfrecuencias_pagos';
	public $timestamps = false;

	protected $casts = [
		'cantidad_mes' => 'int'
	];

	protected $fillable = [
		'nom_frecuencia',
		'cantidad_mes'
	];

	public function detalle_pagos()
	{
		return $this->hasMany(DetallePago::class, 'fk_idfrecuencias_pagos');
	}
}
