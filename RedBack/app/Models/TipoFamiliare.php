<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoFamiliare
 * 
 * @property int $idtipo_familiares
 * @property string $nom_tipo
 * 
 * @property Collection|Familiare[] $familiares
 *
 * @package App\Models
 */
class TipoFamiliare extends Model
{
	protected $connection = 'mysql';
	protected $table = 'tipo_familiares';
	protected $primaryKey = 'idtipo_familiares';
	public $timestamps = false;

	protected $fillable = [
		'nom_tipo'
	];

	public function familiares()
	{
		return $this->hasMany(Familiare::class, 'fk_idtipo_familiares');
	}
}
