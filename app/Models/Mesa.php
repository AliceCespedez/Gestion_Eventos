<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $table = 'mesas';
    protected $primaryKey = 'id_mesa';
    public $timestamps = false;

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    public function asientos()
    {
        return $this->hasMany(Asiento::class, 'id_mesa', 'id_mesa');
    }
}
