<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Distrito
 * 
 * @property int $iddistritos
 * @property string $nom_distrito
 * @property int $fk_idprovincias
 * 
 * @property Provincia $provincia
 * @property Collection|Empadronado[] $empadronados
 *
 * @package App\Models
 */
class Distrito extends Model
{
	protected $connection = 'mysql';
	protected $table = 'distritos';
	protected $primaryKey = 'iddistritos';
	public $timestamps = false;

	protected $casts = [
		'fk_idprovincias' => 'int'
	];

	protected $fillable = [
		'nom_distrito',
		'fk_idprovincias'
	];

	public function provincia()
	{
		return $this->belongsTo(Provincia::class, 'fk_idprovincias');
	}

	public function empadronados()
	{
		return $this->hasMany(Empadronado::class, 'fk_iddistritos');
	}
}
