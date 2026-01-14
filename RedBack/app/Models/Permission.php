<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * 
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|ModelHasPermission[] $model_has_permissions
 * @property RoleHasPermission|null $role_has_permission
 *
 * @package App\Models
 */
class Permission extends Model
{
	protected $connection = 'mysql';
	protected $table = 'permissions';

	protected $fillable = [
		'name',
		'guard_name'
	];

	public function model_has_permissions()
	{
		return $this->hasMany(ModelHasPermission::class);
	}

	public function role_has_permission()
	{
		return $this->hasOne(RoleHasPermission::class);
	}
}
