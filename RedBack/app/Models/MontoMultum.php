<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MontoMultum
 * 
 * @property int $idmonto_multa
 * @property float $multa
 * @property string|null $descripcion
 * 
 * @property Collection|Multa[] $multas
 *
 * @package App\Models
 */
class MontoMultum extends Model
{
	protected $connection = 'mysql';
	protected $table = 'monto_multa';
	protected $primaryKey = 'idmonto_multa';
	public $timestamps = false;

	protected $casts = [
		'multa' => 'float'
	];

	protected $fillable = [
		'multa',
		'descripcion'
	];

	public function multas()
	{
		return $this->hasMany(Multa::class, 'fk_idmonto_multa');
	}
}
