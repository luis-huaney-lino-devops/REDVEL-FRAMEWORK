<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoReunion
 * 
 * @property int $idtipo_reunion
 * @property string $nom_reunion
 * 
 * @property Collection|Reunione[] $reuniones
 *
 * @package App\Models
 */
class TipoReunion extends Model
{
	protected $connection = 'mysql';
	protected $table = 'tipo_reunion';
	protected $primaryKey = 'idtipo_reunion';
	public $timestamps = false;

	protected $fillable = [
		'nom_reunion'
	];

	public function reuniones()
	{
		return $this->hasMany(Reunione::class, 'fk_idtipo_reunion');
	}
}
