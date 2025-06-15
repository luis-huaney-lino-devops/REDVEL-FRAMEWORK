<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DetalleInventario
 * 
 * @property int $iddetalle_inventarios
 * @property Carbon $fecha
 * @property int $cantidad
 * @property string|null $descripcion
 * @property int $fk_idinventarios
 * @property int $fk_idjuntas_directivas
 * 
 * @property Inventario $inventario
 * @property JuntasDirectiva $juntas_directiva
 *
 * @package App\Models
 */
class DetalleInventario extends Model
{
	protected $connection = 'mysql';
	protected $table = 'detalle_inventarios';
	protected $primaryKey = 'iddetalle_inventarios';
	public $timestamps = false;

	protected $casts = [
		'fecha' => 'datetime',
		'cantidad' => 'int',
		'fk_idinventarios' => 'int',
		'fk_idjuntas_directivas' => 'int'
	];

	protected $fillable = [
		'fecha',
		'cantidad',
		'descripcion',
		'fk_idinventarios',
		'fk_idjuntas_directivas'
	];

	public function inventario()
	{
		return $this->belongsTo(Inventario::class, 'fk_idinventarios');
	}

	public function juntas_directiva()
	{
		return $this->belongsTo(JuntasDirectiva::class, 'fk_idjuntas_directivas');
	}
}
