<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    protected $primaryKey = 'id_invitado';

    protected $fillable = [
        'nombre',
        'email',
        'confirmacion',
        'id_evento'
        // ❌ quitamos id_asiento
    ];

    /* RELACIONES */

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }

    // ✅ CORRECTO: el FK está en asientos
    public function asiento()
    {
        return $this->hasOne(Asiento::class, 'id_invitado', 'id_invitado');
    }
}
