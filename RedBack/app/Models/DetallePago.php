<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DetallePago
 * 
 * @property int $iddetalle_pagos
 * @property string $codigo_comprobante
 * @property string|null $descripcion
 * @property float $monto_detalle
 * @property int $fk_idpagos
 * @property int $fk_idempadronados
 * @property int|null $fk_idfrecuencias_pagos
 * @property int $fk_idconcepto_pago
 * 
 * @property ConceptoPago $concepto_pago
 * @property Empadronado $empadronado
 * @property FrecuenciasPago|null $frecuencias_pago
 * @property Pago $pago
 *
 * @package App\Models
 */
class DetallePago extends Model
{
	protected $connection = 'mysql';
	protected $table = 'detalle_pagos';
	protected $primaryKey = 'iddetalle_pagos';
	public $timestamps = false;

	protected $casts = [
		'monto_detalle' => 'float',
		'fk_idpagos' => 'int',
		'fk_idempadronados' => 'int',
		'fk_idfrecuencias_pagos' => 'int',
		'fk_idconcepto_pago' => 'int'
	];

	protected $fillable = [
		'codigo_comprobante',
		'descripcion',
		'monto_detalle',
		'fk_idpagos',
		'fk_idempadronados',
		'fk_idfrecuencias_pagos',
		'fk_idconcepto_pago'
	];

	public function concepto_pago()
	{
		return $this->belongsTo(ConceptoPago::class, 'fk_idconcepto_pago');
	}

	public function empadronado()
	{
		return $this->belongsTo(Empadronado::class, 'fk_idempadronados');
	}

	public function frecuencias_pago()
	{
		return $this->belongsTo(FrecuenciasPago::class, 'fk_idfrecuencias_pagos');
	}

	public function pago()
	{
		return $this->belongsTo(Pago::class, 'fk_idpagos');
	}
}
