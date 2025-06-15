<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConceptoCambio
 * 
 * @property int $idconcepto_cambio
 * @property string $nom_cambio
 * 
 * @property Collection|CambioTitular[] $cambio_titulars
 *
 * @package App\Models
 */
class ConceptoCambio extends Model
{
	protected $connection = 'mysql';
	protected $table = 'concepto_cambio';
	protected $primaryKey = 'idconcepto_cambio';
	public $timestamps = false;

	protected $fillable = [
		'nom_cambio'
	];

	public function cambio_titulars()
	{
		return $this->hasMany(CambioTitular::class, 'fk_idconcepto_cambio');
	}
}
