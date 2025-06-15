<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pago
 * 
 * @property int $idpagos
 * @property Carbon $fecha_pago
 * @property float $monto_pago
 * @property int $fk_idmetodos_pagos
 * 
 * @property MetodosPago $metodos_pago
 * @property Collection|DetallePago[] $detalle_pagos
 *
 * @package App\Models
 */
class Pago extends Model
{
	protected $connection = 'mysql';
	protected $table = 'pagos';
	protected $primaryKey = 'idpagos';
	public $timestamps = false;

	protected $casts = [
		'fecha_pago' => 'datetime',
		'monto_pago' => 'float',
		'fk_idmetodos_pagos' => 'int'
	];

	protected $fillable = [
		'fecha_pago',
		'monto_pago',
		'fk_idmetodos_pagos'
	];

	public function metodos_pago()
	{
		return $this->belongsTo(MetodosPago::class, 'fk_idmetodos_pagos');
	}

	public function detalle_pagos()
	{
		return $this->hasMany(DetallePago::class, 'fk_idpagos');
	}
}
