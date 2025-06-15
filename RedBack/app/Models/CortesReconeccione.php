<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CortesReconeccione
 * 
 * @property int $idcortes_reconecciones
 * @property Carbon $fecha
 * @property bool $tipo
 * @property string $servicio
 * @property int $fk_idviviendas
 * 
 * @property Vivienda $vivienda
 *
 * @package App\Models
 */
class CortesReconeccione extends Model
{
	protected $connection = 'mysql';
	protected $table = 'cortes_reconecciones';
	protected $primaryKey = 'idcortes_reconecciones';
	public $timestamps = false;

	protected $casts = [
		'fecha' => 'datetime',
		'tipo' => 'bool',
		'fk_idviviendas' => 'int'
	];

	protected $fillable = [
		'fecha',
		'tipo',
		'servicio',
		'fk_idviviendas'
	];

	public function vivienda()
	{
		return $this->belongsTo(Vivienda::class, 'fk_idviviendas');
	}
}
