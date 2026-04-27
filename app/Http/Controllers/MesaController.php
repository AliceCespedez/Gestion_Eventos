<?php

namespace App\Http\Controllers;

use App\Models\Mesa;

class MesaController extends Controller
{
    public function porEvento($eventoId)
    {
        return Mesa::with(['asientos.invitado'])
            ->where('id_evento', $eventoId)
            ->get();
    }
}