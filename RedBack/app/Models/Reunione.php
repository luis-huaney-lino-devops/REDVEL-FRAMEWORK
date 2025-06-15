<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reunione
 * 
 * @property int $idreuniones
 * @property Carbon $fecha_reunion
 * @property string $lugar
 * @property string|null $descripcion
 * @property int $fk_idtipo_reunion
 * 
 * @property TipoReunion $tipo_reunion
 * @property Collection|ReunionesPaticipacione[] $reuniones_paticipaciones
 *
 * @package App\Models
 */
class Reunione extends Model
{
	protected $connection = 'mysql';
	protected $table = 'reuniones';
	protected $primaryKey = 'idreuniones';
	public $timestamps = false;

	protected $casts = [
		'fecha_reunion' => 'datetime',
		'fk_idtipo_reunion' => 'int'
	];

	protected $fillable = [
		'fecha_reunion',
		'lugar',
		'descripcion',
		'fk_idtipo_reunion'
	];

	public function tipo_reunion()
	{
		return $this->belongsTo(TipoReunion::class, 'fk_idtipo_reunion');
	}

	public function reuniones_paticipaciones()
	{
		return $this->hasMany(ReunionesPaticipacione::class, 'fk_idreuniones');
	}
}
