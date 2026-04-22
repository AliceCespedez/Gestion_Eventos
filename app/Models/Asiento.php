<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    protected $table = 'asiento';
    protected $primaryKey = 'id_asiento';
    public $timestamps = false;

    protected $fillable = [
        'id_mesa',
        'numero_asiento',
        'id_invitado'
    ];

    /* RELACIONES */

    public function invitado()
    {
        return $this->belongsTo(Invitado::class, 'id_invitado', 'id_invitado');
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'id_mesa', 'id_mesa');
    }
}
