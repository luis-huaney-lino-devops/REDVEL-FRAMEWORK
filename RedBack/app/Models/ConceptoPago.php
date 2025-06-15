<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConceptoPago
 * 
 * @property int $idconcepto_pago
 * @property string $nom_concepto
 * @property float $costo
 * 
 * @property Collection|DetallePago[] $detalle_pagos
 *
 * @package App\Models
 */
class ConceptoPago extends Model
{
	protected $connection = 'mysql';
	protected $table = 'concepto_pago';
	protected $primaryKey = 'idconcepto_pago';
	public $timestamps = false;

	protected $casts = [
		'costo' => 'float'
	];

	protected $fillable = [
		'nom_concepto',
		'costo'
	];

	public function detalle_pagos()
	{
		return $this->hasMany(DetallePago::class, 'fk_idconcepto_pago');
	}
}
