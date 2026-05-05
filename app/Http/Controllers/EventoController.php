<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Local;
use App\Models\Menu;
use App\Models\TipoEvento;
use App\Models\Invitado;
use App\Models\Evento;
use App\Models\Servicio;

class EventoController extends Controller
{
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

    public function create()
    {
        return view('eventos.create');
    }

    public function adminCreate()
    {
        return view('eventos.admin_create', [
            'locales' => Local::all(),
            'tipos' => TipoEvento::all(),
            'menus' => Menu::all(),
            'clientes' => \App\Models\Usuario::where('rol', 'cliente')->get(),
            'servicios' => \App\Models\Servicio::all()
        ]);
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

        $costeTotal = $this->calcularCosteEvento($evento);
        $presupuestoRestante = $evento->presupuesto - $costeTotal;

        return view('eventos.show', array_merge([
            'evento' => $evento,
            'menus' => Menu::all(),
            'servicios' => Servicio::all(),
            'costeTotal' => $costeTotal,
            'presupuestoRestante' => $presupuestoRestante
        ], $data));
    }

    public function summary(Evento $evento)
    {
        $this->authorizeEvento($evento);

        $evento->load([
            'tipo',
            'usuario',
            'local',
            'invitados',
            'menus',
            'servicios'
        ]);

        $data = $this->getDashboardData($evento);

        return view('eventos.summary', array_merge([
            'evento' => $evento
        ], $data));
    }

    private function authorizeEvento(Evento $evento)
    {
        $user = Auth::user();

        if (in_array($user->rol, ['admin', 'empleado'])) {
            return true;
        }

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
            'totalCatering'
        );
    }

    public function dashboardAdmin()
    {
        $user = Auth::user();

        if ($user->rol !== 'admin') {
            abort(403);
        }

        $eventosPorMes = DB::table('eventos')
            ->selectRaw('MONTH(fecha) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return view('eventos.dashboardAdmin', compact('eventosPorMes'));
    }

    public function attachMenu(Request $request, Evento $evento)
    {
        $user = Auth::user();

        if (!in_array($user->rol, ['admin', 'empleado'])) {
            abort(403, 'No tienes permiso para añadir menús');
        }

        $request->validate([
            'menu_id' => 'required|exists:menu,id_menu',
            'cantidad' => 'required|integer|min:1',
        ]);

        if ($evento->menus()->wherePivot('id_menu', $request->menu_id)->exists()) {
            $evento->menus()->updateExistingPivot($request->menu_id, [
                'cantidad' => $request->cantidad,
            ]);
        } else {
            $evento->menus()->attach($request->menu_id, [
                'cantidad' => $request->cantidad,
            ]);
        }

        return back()->with('success', 'Menú añadido correctamente al evento');
    }

    public function updateMenu(Request $request, Evento $evento, Menu $menu)
    {
        $user = Auth::user();

        if (!in_array($user->rol, ['admin', 'empleado'])) {
            abort(403, 'No tienes permiso para actualizar menús');
        }

        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $evento->menus()->updateExistingPivot($menu->id_menu, [
            'cantidad' => $request->cantidad,
        ]);

        return back()->with('success', 'Cantidad de menú actualizada correctamente');
    }

    public function detachMenu(Evento $evento, Menu $menu)
    {
        $user = Auth::user();

        if (!in_array($user->rol, ['admin', 'empleado'])) {
            abort(403, 'No tienes permiso para eliminar menús');
        }

        $evento->menus()->detach($menu->id_menu);

        return back()->with('success', 'Menú eliminado correctamente del evento');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'nombre_evento' => 'required|string|max:255',
            'fecha' => ['required', 'date', 'after_or_equal:today'],
            'presupuesto' => ['required', 'numeric', 'min:1'],
            'menus' => 'required|array|min:1',
            'cantidad' => 'required|array',
            'num_mesas' => 'required|integer|min:1',
            'asientos_mesa' => 'required|integer|min:1',
        ];

        if ($user->rol !== 'cliente') {
            $rules['local_id'] = ['required', 'exists:locales,id_local'];
            $rules['tipo_id'] = ['required', 'exists:tipo_evento,id_tipo'];
            $rules['id_usuario'] = ['required', 'exists:usuarios,id_usuario'];
        }

        $request->validate($rules);

        if ($user->rol === 'cliente') {

            Evento::create([
                'nombre_evento' => $request->nombre_evento,
                'fecha' => $request->fecha,
                'id_usuario' => $user->id_usuario,
                'presupuesto' => $request->presupuesto,
                'estado' => 'pendiente'
            ]);

            return redirect()->route('eventos.index');
        }

        $evento = Evento::create([
            'nombre_evento' => $request->nombre_evento,
            'fecha' => $request->fecha,
            'id_usuario' => $request->id_usuario,
            'id_local' => $request->local_id,
            'id_tipo' => $request->tipo_id,
            'presupuesto' => $request->presupuesto,
            'estado' => 'confirmado'
        ]);

        foreach ($request->menus as $menuId) {
            if ($menuId) {
                $evento->menus()->attach($menuId, [
                    'cantidad' => $request->cantidad[$menuId] ?? 1
                ]);
            }
        }

        if ($request->invitados) {
            foreach ($request->invitados as $inv) {
                if (!empty($inv['nombre'])) {
                    Invitado::create([
                        'nombre' => $inv['nombre'],
                        'email' => $inv['email'] ?? null,
                        'telefono' => $inv['telefono'] ?? null,
                        'id_evento' => $evento->id_evento
                    ]);
                }
            }
        }

        //  MESAS + ASIENTOS 
        for ($i = 1; $i <= $request->num_mesas; $i++) {

            $mesa = \App\Models\Mesa::create([
                'id_evento' => $evento->id_evento,
                'numero_mesa' => $i,
                'capacidad' => $request->asientos_mesa
            ]);

            for ($j = 1; $j <= $request->asientos_mesa; $j++) {

                \App\Models\Asiento::create([
                    'id_mesa' => $mesa->id_mesa,
                    'numero_asiento' => $j,
                    'id_invitado' => null
                ]);
            }
        }

        return redirect()->route('eventos.index');
    }
    //Servicios
    //Añadir Servicios
    public function attachServicio(Request $request, Evento $evento)
    {
        $request->validate([
            'servicio_id' => 'required|exists:servicios,id_servicio',
            'cantidad' => 'required|integer|min:1',
        ]);

        $servicio = \App\Models\Servicio::findOrFail($request->servicio_id);

        $precioTotal = $servicio->precio_unitario * $request->cantidad;

        $evento->servicios()->syncWithoutDetaching([
            $servicio->id_servicio => [
                'cantidad' => $request->cantidad,
                'precio_total' => $precioTotal
            ]
        ]);

        return back();
    }

    //Editar cantidad
    public function updateServicio(Request $request, Evento $evento, Servicio $servicio)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        $precioTotal = $servicio->precio_unitario * $request->cantidad;

        $evento->servicios()->updateExistingPivot($servicio->id_servicio, [
            'cantidad' => $request->cantidad,
            'precio_total' => $precioTotal
        ]);

        return back()->with('success', 'Servicio actualizado');
    }

    //Eliminar servicio
    public function detachServicio(Evento $evento, Servicio $servicio)
    {
        $evento->servicios()->detach($servicio->id_servicio);

        return back()->with('success', 'Servicio eliminado');
    }

    //Presupuesto total del evento (menús + servicios + local)
    private function calcularCosteEvento($evento)
    {
        $total = 0;

        // MENÚS
        foreach ($evento->menus as $menu) {
            $total += $menu->precio_unitario * $menu->pivot->cantidad;
        }

        // SERVICIOS
        foreach ($evento->servicios as $servicio) {
            $total += $servicio->precio_unitario * $servicio->pivot->cantidad;
        }

        // LOCAL (ejemplo: si tiene precio)
        if ($evento->local) {
            $total += $evento->local->precio ?? 0;
        }

        return $total;
    }

    //Presupuesto restante del evento (presupuesto - coste)
    private function getPresupuestoRestante($evento)
    {
        return $evento->presupuesto - $this->calcularCosteEvento($evento);
    }
}
