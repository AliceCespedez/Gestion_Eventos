<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Usuario;
use App\Notifications\NuevaConsulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'asunto' => 'required',
            'mensaje' => 'required',
            'tipo_consulta' => 'required',
            'prioridad' => 'required',
        ]);

        $consulta = Consulta::create([
            'id_usuario' => Auth::id(),
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
            'tipo_consulta' => $request->tipo_consulta,
            'prioridad' => $request->prioridad,
        ]);

        //  ENVIAR NOTIFICACIÓN A ADMIN Y EMPLEADOS
        $usuarios = Usuario::whereIn('rol', ['admin', 'empleado'])->get();

        foreach ($usuarios as $user) {
            $user->notify(new NuevaConsulta($consulta));
        }

        return back()->with('success', 'Consulta enviada correctamente');
    }

    public function index()
    {
        abort_unless(in_array(auth()->user()->rol, ['admin', 'empleado']), 403);

        $consultas = Consulta::latest()->get();

        //  esto limpia la campana al entrar
        auth()->user()->unreadNotifications->markAsRead();

        return view('consultas.index', compact('consultas'));
    }

    public function marcarLeido($id)
    {
        $consulta = Consulta::findOrFail($id);

        $consulta->leido = true;

        $consulta->save();

        return back()->with('success', 'Consulta marcada como leída');
    }

    public function destroy($id)
    {
        $consulta = Consulta::findOrFail($id);

        $consulta->delete();

        return back()->with('success', 'Consulta eliminada');
    }
}
