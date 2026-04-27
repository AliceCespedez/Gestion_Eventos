<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    protected $primaryKey = 'id_invitado';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'confirmacion',
        'id_evento'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }

    public function asiento()
    {
        return $this->hasOne(Asiento::class, 'id_invitado', 'id_invitado');
    }
}

