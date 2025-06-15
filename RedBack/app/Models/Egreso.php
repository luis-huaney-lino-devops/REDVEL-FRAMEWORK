<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Egreso
 * 
 * @property int $idegresos
 * @property Carbon $fecha
 * @property float $egreso_total
 * @property float|null $impuesto
 * 
 * @property Collection|DetalleEgreso[] $detalle_egresos
 *
 * @package App\Models
 */
class Egreso extends Model
{
	protected $connection = 'mysql';
	protected $table = 'egresos';
	protected $primaryKey = 'idegresos';
	public $timestamps = false;

	protected $casts = [
		'fecha' => 'datetime',
		'egreso_total' => 'float',
		'impuesto' => 'float'
	];

	protected $fillable = [
		'fecha',
		'egreso_total',
		'impuesto'
	];

	public function detalle_egresos()
	{
		return $this->hasMany(DetalleEgreso::class, 'fk_idegresos');
	}
}
