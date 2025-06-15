<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Genero
 * 
 * @property int $idgeneros
 * @property string $nom_genero
 * 
 * @property Collection|Persona[] $personas
 *
 * @package App\Models
 */
class Genero extends Model
{
	protected $connection = 'mysql';
	protected $table = 'generos';
	protected $primaryKey = 'idgeneros';
	public $timestamps = false;

	protected $fillable = [
		'nom_genero'
	];

	public function personas()
	{
		return $this->hasMany(Persona::class, 'fk_idgeneros');
	}
}
