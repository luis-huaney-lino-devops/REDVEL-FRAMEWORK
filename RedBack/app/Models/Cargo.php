<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cargo
 * 
 * @property int $idcargo
 * @property string $nom_cargo
 * 
 * @property Collection|JuntasDirectiva[] $juntas_directivas
 *
 * @package App\Models
 */
class Cargo extends Model
{
	protected $connection = 'mysql';
	protected $table = 'cargo';
	protected $primaryKey = 'idcargo';
	public $timestamps = false;

	protected $fillable = [
		'nom_cargo'
	];

	public function juntas_directivas()
	{
		return $this->hasMany(JuntasDirectiva::class, 'fk_idcargo');
	}
}
