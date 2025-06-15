<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MetodosPago
 * 
 * @property int $idmetodos_pagos
 * @property string $nom_pago
 * 
 * @property Collection|Pago[] $pagos
 *
 * @package App\Models
 */
class MetodosPago extends Model
{
	protected $connection = 'mysql';
	protected $table = 'metodos_pagos';
	protected $primaryKey = 'idmetodos_pagos';
	public $timestamps = false;

	protected $fillable = [
		'nom_pago'
	];

	public function pagos()
	{
		return $this->hasMany(Pago::class, 'fk_idmetodos_pagos');
	}
}
