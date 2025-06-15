<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GradoInstruccione
 * 
 * @property int $idgrado_instrucciones
 * @property string $nom_grado
 * 
 * @property Collection|Empadronado[] $empadronados
 *
 * @package App\Models
 */
class GradoInstruccione extends Model
{
	protected $connection = 'mysql';
	protected $table = 'grado_instrucciones';
	protected $primaryKey = 'idgrado_instrucciones';
	public $timestamps = false;

	protected $fillable = [
		'nom_grado'
	];

	public function empadronados()
	{
		return $this->hasMany(Empadronado::class, 'fk_idgrado_instrucciones');
	}
}
