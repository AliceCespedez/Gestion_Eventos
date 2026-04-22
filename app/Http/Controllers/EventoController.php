<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    //Listado de eventos
    public function index()
    {
        if (Auth::user()->rol === 'empleado') {
            $eventos = Evento::with(['tipo', 'usuario'])->get();
        } else {
            $eventos = Evento::with(['tipo'])
                ->where('id_usuario', Auth::user()->id_usuario)
                ->get();
        }

        return view('eventos.index', compact('eventos'));
    }

    //Detalle del evento + seating plan
    public function show(Evento $evento)
    {
        $this->authorizeEvento($evento);

        $evento->load([
            'tipo',
            'usuario',
            'invitados.asiento',
            'mesas.asientos.invitado'
        ]);

        return view('eventos.show', compact('evento'));
    }

    //Protección de acceso a eventos según rol 
    private function authorizeEvento(Evento $evento)
    {
        $user = Auth::user();

        if ($user->rol === 'empleado') {
            return true;
        }

        if ($evento->id_usuario !== $user->id_usuario) {
            abort(403, 'No tienes acceso a este evento');
        }

        return true;
    }
}