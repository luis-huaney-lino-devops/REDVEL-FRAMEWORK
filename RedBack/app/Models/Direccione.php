<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Direccione
 * 
 * @property int $iddirecciones
 * @property string $nom_direccion
 * 
 * @property Collection|Vivienda[] $viviendas
 *
 * @package App\Models
 */
class Direccione extends Model
{
	protected $connection = 'mysql';
	protected $table = 'direcciones';
	protected $primaryKey = 'iddirecciones';
	public $timestamps = false;

	protected $fillable = [
		'nom_direccion'
	];

	public function viviendas()
	{
		return $this->hasMany(Vivienda::class, 'fk_iddirecciones');
	}
}
