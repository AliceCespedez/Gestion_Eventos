<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $primaryKey = 'id_servicio';
    public $timestamps = false;

    public function eventos()
    {
        return $this->belongsToMany(
            \App\Models\Evento::class,
            'servicios_contratados',   
            'id_servicio',
            'id_evento'
        )->withPivot('cantidad', 'precio_total');
    }
}
