<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DetalleEgreso
 * 
 * @property int $iddetalle_egresos
 * @property Carbon $fecha_egreso
 * @property float $monto
 * @property string $ruta_boleta
 * @property string $descripcion_egre
 * @property int $fk_idegresos
 * @property int $fk_idjuntas_directivas
 * 
 * @property Egreso $egreso
 * @property JuntasDirectiva $juntas_directiva
 *
 * @package App\Models
 */
class DetalleEgreso extends Model
{
	protected $connection = 'mysql';
	protected $table = 'detalle_egresos';
	protected $primaryKey = 'iddetalle_egresos';
	public $timestamps = false;

	protected $casts = [
		'fecha_egreso' => 'datetime',
		'monto' => 'float',
		'fk_idegresos' => 'int',
		'fk_idjuntas_directivas' => 'int'
	];

	protected $fillable = [
		'fecha_egreso',
		'monto',
		'ruta_boleta',
		'descripcion_egre',
		'fk_idegresos',
		'fk_idjuntas_directivas'
	];

	public function egreso()
	{
		return $this->belongsTo(Egreso::class, 'fk_idegresos');
	}

	public function juntas_directiva()
	{
		return $this->belongsTo(JuntasDirectiva::class, 'fk_idjuntas_directivas');
	}
}
