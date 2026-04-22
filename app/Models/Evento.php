<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';
    protected $primaryKey = 'id_evento';
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoEvento::class, 'id_tipo', 'id_tipo');
    }

    public function invitados()
    {
        return $this->hasMany(Invitado::class, 'id_evento', 'id_evento');
    }

    public function mesas()
    {
        return $this->hasMany(Mesa::class, 'id_evento', 'id_evento');
    }

    public function servicios()
    {
        return $this->belongsToMany(
            Servicio::class,
            'servicios_contratados',
            'id_evento',   // FK en pivot
            'id_servicio', // FK relacionada
            'id_evento',   // local key
            'id_servicio'  // related key
        )->withPivot('cantidad','precio_total');
    }
}