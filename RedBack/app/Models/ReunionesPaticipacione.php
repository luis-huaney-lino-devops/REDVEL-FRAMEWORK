<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReunionesPaticipacione
 * 
 * @property int $idreuniones_paticipaciones
 * @property Carbon $fecha
 * @property bool $asistio
 * @property int $fk_idreuniones
 * @property int $fk_idempadronados
 * 
 * @property Empadronado $empadronado
 * @property Reunione $reunione
 * @property Collection|Multa[] $multas
 *
 * @package App\Models
 */
class ReunionesPaticipacione extends Model
{
	protected $connection = 'mysql';
	protected $table = 'reuniones_paticipaciones';
	protected $primaryKey = 'idreuniones_paticipaciones';
	public $timestamps = false;

	protected $casts = [
		'fecha' => 'datetime',
		'asistio' => 'bool',
		'fk_idreuniones' => 'int',
		'fk_idempadronados' => 'int'
	];

	protected $fillable = [
		'fecha',
		'asistio',
		'fk_idreuniones',
		'fk_idempadronados'
	];

	public function empadronado()
	{
		return $this->belongsTo(Empadronado::class, 'fk_idempadronados');
	}

	public function reunione()
	{
		return $this->belongsTo(Reunione::class, 'fk_idreuniones');
	}

	public function multas()
	{
		return $this->hasMany(Multa::class, 'fk_idreuniones_paticipaciones');
	}
}
