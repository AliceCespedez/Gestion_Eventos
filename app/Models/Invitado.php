<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    protected $table = 'invitados';
    protected $primaryKey = 'id_invitado';
    public $timestamps = false;

    public function evento()
    {
        return $this->belongsTo(Evento::class,'id_evento');
    }
    public function asiento()
    {
        return $this->belongsTo(Asiento::class, 'id_asiento');

    }
}
