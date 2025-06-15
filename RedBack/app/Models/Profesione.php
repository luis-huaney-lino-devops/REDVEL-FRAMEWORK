<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profesione
 * 
 * @property int $idprofesiones
 * @property string $nom_profesion
 * 
 * @property Collection|Empadronado[] $empadronados
 *
 * @package App\Models
 */
class Profesione extends Model
{
	protected $connection = 'mysql';
	protected $table = 'profesiones';
	protected $primaryKey = 'idprofesiones';
	public $timestamps = false;

	protected $fillable = [
		'nom_profesion'
	];

	public function empadronados()
	{
		return $this->hasMany(Empadronado::class, 'fk_idprofesiones');
	}
}
