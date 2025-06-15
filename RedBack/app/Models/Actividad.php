<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Actividad
 * 
 * @property int $idactividad
 * @property string $nom_actividad
 * 
 * @property Collection|Empadronado[] $empadronados
 * @property Collection|Familiare[] $familiares
 *
 * @package App\Models
 */
class Actividad extends Model
{
	protected $connection = 'mysql';
	protected $table = 'actividad';
	protected $primaryKey = 'idactividad';
	public $timestamps = false;

	protected $fillable = [
		'nom_actividad'
	];

	public function empadronados()
	{
		return $this->hasMany(Empadronado::class, 'fk_idactividad');
	}

	public function familiares()
	{
		return $this->hasMany(Familiare::class, 'fk_idactividad');
	}
}
