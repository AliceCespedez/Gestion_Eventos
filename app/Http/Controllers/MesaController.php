<?php

namespace App\Http\Controllers;

use App\Models\Mesa;

class MesaController extends Controller
{
    public function index($eventoId)
    {
        $mesas = Mesa::with(['asientos.invitado'])
            ->where('id_evento', $eventoId)
            ->get();

        return response()->json($mesas);
    }
}