<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CambioTitular
 * 
 * @property int $idcambio_titular
 * @property Carbon $fecha_cambio
 * @property int $fk_idempadronados
 * @property int $fk_idconcepto_cambio
 * 
 * @property ConceptoCambio $concepto_cambio
 * @property Empadronado $empadronado
 *
 * @package App\Models
 */
class CambioTitular extends Model
{
	protected $connection = 'mysql';
	protected $table = 'cambio_titular';
	protected $primaryKey = 'idcambio_titular';
	public $timestamps = false;

	protected $casts = [
		'fecha_cambio' => 'datetime',
		'fk_idempadronados' => 'int',
		'fk_idconcepto_cambio' => 'int'
	];

	protected $fillable = [
		'fecha_cambio',
		'fk_idempadronados',
		'fk_idconcepto_cambio'
	];

	public function concepto_cambio()
	{
		return $this->belongsTo(ConceptoCambio::class, 'fk_idconcepto_cambio');
	}

	public function empadronado()
	{
		return $this->belongsTo(Empadronado::class, 'fk_idempadronados');
	}
}
