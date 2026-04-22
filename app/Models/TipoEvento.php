<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model
{
    protected $table = 'tipo_evento';
    protected $primaryKey = 'id_tipo';
    public $timestamps = false;

    protected $fillable = [
        'nombre_tipo'
    ];

    // Relación: un tipo tiene muchos eventos
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'id_tipo', 'id_tipo');
    }
}