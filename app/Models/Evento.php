<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';
    protected $primaryKey = 'id_evento';
    public $timestamps = false;

public function invitados()
{
    return $this->hasMany(Invitado::class, 'id_evento');
}
public function mesas()
{
    return $this->hasMany(Mesa::class, 'id_evento');
}
public function servicios()
{
    return $this->belongsToMany(Servicio::class, 'servicios_contratados')
                ->withPivot('cantidad','precio_total');
}

}


