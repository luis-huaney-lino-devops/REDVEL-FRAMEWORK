<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventario
 * 
 * @property int $idinventarios
 * @property string $nom_inventario
 * 
 * @property Collection|DetalleInventario[] $detalle_inventarios
 *
 * @package App\Models
 */
class Inventario extends Model
{
	protected $connection = 'mysql';
	protected $table = 'inventarios';
	protected $primaryKey = 'idinventarios';
	public $timestamps = false;

	protected $fillable = [
		'nom_inventario'
	];

	public function detalle_inventarios()
	{
		return $this->hasMany(DetalleInventario::class, 'fk_idinventarios');
	}
}
