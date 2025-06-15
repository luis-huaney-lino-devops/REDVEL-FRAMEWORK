<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Departamento
 * 
 * @property int $iddepartamentos
 * @property string $nom_depa
 * 
 * @property Collection|Provincia[] $provincias
 *
 * @package App\Models
 */
class Departamento extends Model
{
	protected $connection = 'mysql';
	protected $table = 'departamentos';
	protected $primaryKey = 'iddepartamentos';
	public $timestamps = false;

	protected $fillable = [
		'nom_depa'
	];

	public function provincias()
	{
		return $this->hasMany(Provincia::class, 'fk_iddepartamentos');
	}
}
