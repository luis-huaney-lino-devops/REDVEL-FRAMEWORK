<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Multa
 * 
 * @property int $idmultas
 * @property Carbon $fecha
 * @property bool $estado_detalle
 * @property string $descripcion
 * @property int $fk_idreuniones_paticipaciones
 * @property int $fk_idmonto_multa
 * 
 * @property MontoMultum $monto_multum
 * @property ReunionesPaticipacione $reuniones_paticipacione
 *
 * @package App\Models
 */
class Multa extends Model
{
	protected $connection = 'mysql';
	protected $table = 'multas';
	protected $primaryKey = 'idmultas';
	public $timestamps = false;

	protected $casts = [
		'fecha' => 'datetime',
		'estado_detalle' => 'bool',
		'fk_idreuniones_paticipaciones' => 'int',
		'fk_idmonto_multa' => 'int'
	];

	protected $fillable = [
		'fecha',
		'estado_detalle',
		'descripcion',
		'fk_idreuniones_paticipaciones',
		'fk_idmonto_multa'
	];

	public function monto_multum()
	{
		return $this->belongsTo(MontoMultum::class, 'fk_idmonto_multa');
	}

	public function reuniones_paticipacione()
	{
		return $this->belongsTo(ReunionesPaticipacione::class, 'fk_idreuniones_paticipaciones');
	}
}
