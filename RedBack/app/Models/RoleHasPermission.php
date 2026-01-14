<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RoleHasPermission
 * 
 * @property int $permission_id
 * 
 * @property Permission $permission
 *
 * @package App\Models
 */
class RoleHasPermission extends Model
{
	protected $connection = 'mysql';
	protected $table = 'role_has_permissions';
	protected $primaryKey = 'permission_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'permission_id' => 'int'
	];

	public function permission()
	{
		return $this->belongsTo(Permission::class);
	}
}
