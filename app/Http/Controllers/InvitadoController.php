<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invitado;

class InvitadoController extends Controller
{
    //Cambiar estado de confirmación de un invitado
    public function cambiarEstado(Request $request, Invitado $inv)
    {
        $user = Auth::user();
        // SOLO ADMIN Y EMPLEADO
        if (!in_array($user->rol, ['admin', 'empleado'])) {
            abort(403, 'No tienes permisos para realizar esta acción');
        }

        // VALIDACIÓN DE ESTADO
        $request->validate([
            'confirmacion' => 'required|in:pendiente,confirmado,rechazado'
        ]);

        //  ACTUALIZAR INVITADO
        $inv->update([
            'confirmacion' => $request->confirmacion
        ]);

        return redirect()->back()->with('success', 'Estado actualizado correctamente');
    }

    // Mostrar lista de invitados por evento
    public function index($eventoId)
    {
        $evento = \App\Models\Evento::with('invitados')
            ->findOrFail($eventoId);

        return view('invitados.index', compact('evento'));
    }

    // Agregar nuevo invitado a un evento
    public function store(Request $request, $eventoId)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email',
        ]);

        Invitado::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'id_evento' => $eventoId,
            'confirmacion' => 'pendiente'
        ]);

        return back()->with('success', 'Invitado añadido correctamente');
    }
    public function destroy($id)
    {
        $invitado = Invitado::findOrFail($id);

        $invitado->delete();

        return back()->with('success', 'Invitado eliminado');
    }
}
