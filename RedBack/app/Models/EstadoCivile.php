<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoCivile
 * 
 * @property int $idestado_civiles
 * @property string $nom_estado
 * 
 * @property Collection|Empadronado[] $empadronados
 *
 * @package App\Models
 */
class EstadoCivile extends Model
{
	protected $connection = 'mysql';
	protected $table = 'estado_civiles';
	protected $primaryKey = 'idestado_civiles';
	public $timestamps = false;

	protected $fillable = [
		'nom_estado'
	];

	public function empadronados()
	{
		return $this->hasMany(Empadronado::class, 'fk_idestado_civiles');
	}
}
