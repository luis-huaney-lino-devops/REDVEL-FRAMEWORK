<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sessione
 *
 * @property string $id_sesiones
 * @property string $ip_address
 * @property Carbon $fecha_hora_secion
 * @property int $fk_idusuarios
 *
 * @package App\Models
 */
class Sessione extends Model
{
    protected $table = 'sessiones';
    protected $primaryKey = 'id_sesiones';
    public $incrementing = true;
    public $timestamps = false;

    protected $casts = [
        'fecha_hora_secion' => 'datetime',
        'fk_idusuarios' => 'int'
    ];

    protected $fillable = [
        'ip_address',
        'fecha_hora_secion',
        'fk_idusuarios'
    ];
}
