<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Provincia
 * 
 * @property int $idprovincias
 * @property string $nom_provincia
 * @property int $fk_iddepartamentos
 * 
 * @property Departamento $departamento
 * @property Collection|Distrito[] $distritos
 *
 * @package App\Models
 */
class Provincia extends Model
{
	protected $connection = 'mysql';
	protected $table = 'provincias';
	protected $primaryKey = 'idprovincias';
	public $timestamps = false;

	protected $casts = [
		'fk_iddepartamentos' => 'int'
	];

	protected $fillable = [
		'nom_provincia',
		'fk_iddepartamentos'
	];

	public function departamento()
	{
		return $this->belongsTo(Departamento::class, 'fk_iddepartamentos');
	}

	public function distritos()
	{
		return $this->hasMany(Distrito::class, 'fk_idprovincias');
	}
}
