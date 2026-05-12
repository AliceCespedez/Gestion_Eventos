<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 'consultas';

    protected $primaryKey = 'id_consulta';

    public $timestamps = true;

    protected $fillable = [
        'id_usuario',
        'asunto',
        'mensaje',
        'tipo_consulta',
        'prioridad',
        'leido'
    ];
}
