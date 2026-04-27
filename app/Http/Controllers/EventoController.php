<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventoController extends Controller
{
    //Listado de eventos
    public function index()
    {
        $user = Auth::user();

        $query = Evento::with(['tipo', 'usuario']);

        if ($user->rol === 'cliente') {
            $query->where('id_usuario', $user->id_usuario);
        }

        $eventos = $query->get();

        return view('eventos.index', compact('eventos'));
    }

    public function show(Evento $evento)
    {
        $this->authorizeEvento($evento);

        $evento->load([
            'tipo',
            'usuario',
            'local',
            'invitados.asiento',
            'mesas.asientos.invitado',
            'menus'
        ]);

        $data = $this->getDashboardData($evento);

        return view('eventos.show', array_merge([
            'evento' => $evento
        ], $data));
    }

    //Resumen evento 
    public function summary(Evento $evento)
    {
        $this->authorizeEvento($evento);

        $evento->load([
            'tipo',
            'usuario',
            'local',
            'invitados',
            'menus'
        ]);

        $data = $this->getDashboardData($evento);

        return view('eventos.summary', array_merge([
            'evento' => $evento
        ], $data));
    }

    //Protección de acceso a eventos según rol 
    private function authorizeEvento(Evento $evento)
    {
        $user = Auth::user();

        // Admin 
        if ($user->rol === 'admin') {
            return true;
        }

        // Empleado 
        if ($user->rol === 'empleado') {
            return true;
        }

        //  Cliente solo puede ver sus propios eventos
        if ($evento->id_usuario !== $user->id_usuario) {
            abort(403, 'No tienes acceso a este evento');
        }

        return true;
    }
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->rol === 'empleado') {

            $eventos = Evento::with(['tipo', 'usuario'])->get();
        } else {

            $eventos = Evento::with(['tipo', 'invitados'])
                ->where('id_usuario', $user->id_usuario)
                ->get();
        }

        return view('dashboard', compact('eventos'));
    }

    private function getDashboardData(Evento $evento)
    {
        $stats = [
            'total' => $evento->invitados->count(),
            'confirmados' => $evento->invitados->where('confirmacion', 'confirmado')->count(),
            'pendientes' => $evento->invitados->where('confirmacion', 'pendiente')->count(),
            'rechazados' => $evento->invitados->where('confirmacion', 'rechazado')->count(),
        ];
        $eventosMeses = Evento::selectRaw('MONTH(fecha) as mes, COUNT(*) as cantidad')
            ->groupBy('mes')
            //->pluck('cantidad', 'mes')
            ->get();

        $labelsInvitados = ['Confirmados', 'Pendientes', 'Rechazados'];
        $dataInvitados = [
            $stats['confirmados'],
            $stats['pendientes'],
            $stats['rechazados']
        ];

        $labelsMenus = [];
        $dataMenus = [];
        $totalCatering = 0;

        foreach ($evento->menus as $menu) {
            $labelsMenus[] = $menu->nombre;
            $dataMenus[] = $menu->pivot->cantidad;

            $totalCatering += $menu->precio_unitario * $menu->pivot->cantidad;
        }

        return compact(
            'stats',
            'labelsInvitados',
            'dataInvitados',
            'labelsMenus',
            'dataMenus',
            'totalCatering',
            'eventosMeses',
        );
    }

    public function dashboardAdmin()
    {
        $user = Auth::user();

        if ($user->rol !== 'admin') {
            abort(403);
        }

        // Eventos por mes
        $eventosPorMes = DB::table('eventos')
            ->selectRaw('MONTH(fecha) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return view('eventos.dashboardAdmin', compact('eventosPorMes'));
    }
}
