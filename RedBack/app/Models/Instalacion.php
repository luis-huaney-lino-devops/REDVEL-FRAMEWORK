<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Instalacion
 * 
 * @property int $id_instalacion
 * @property bool $estado_instalacion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Instalacion extends Model
{
	use SoftDeletes;
	protected $connection = 'mysql';
	protected $table = 'instalacion';
	protected $primaryKey = 'id_instalacion';

	protected $casts = [
		'estado_instalacion' => 'bool'
	];

	protected $fillable = [
		'estado_instalacion'
	];
}
