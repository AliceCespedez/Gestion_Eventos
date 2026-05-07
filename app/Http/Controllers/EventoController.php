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

        $gastado = $this->calcularCosteEvento($evento);

        $presupuesto = $evento->presupuesto;

        $restante = $presupuesto - $gastado;

        return view('eventos.summary', array_merge([
            'evento' => $evento,
            'presupuesto' => $presupuesto,
            'gastado' => $gastado,
            'restante' => $restante
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

        // MENÚS
        $labelsMenus = [];
        $dataMenus = [];

        foreach ($evento->menus as $menu) {
            $labelsMenus[] = $menu->nombre;
            $dataMenus[] = $menu->pivot->cantidad;
        }

        // SERVICIOS (NUEVO)
        $labelsServicios = [];
        $dataServicios = [];
        $totalServicios = 0;

        foreach ($evento->servicios as $servicio) {
            $labelsServicios[] = $servicio->nombre;
            $dataServicios[] = $servicio->pivot->cantidad;

            $totalServicios += $servicio->precio_unitario * $servicio->pivot->cantidad;
        }

        // COSTES
        $totalMenus = 0;

        foreach ($evento->menus as $menu) {
            $totalMenus += $menu->precio_unitario * $menu->pivot->cantidad;
        }

        $totalLocal = $evento->local->precio ?? 0;

        $gastado = $totalMenus + $totalServicios + $totalLocal;

        return [
            'stats' => $stats,
            'labelsInvitados' => ['Confirmados', 'Pendientes', 'Rechazados'],
            'dataInvitados' => [
                $stats['confirmados'],
                $stats['pendientes'],
                $stats['rechazados']
            ],

            'labelsMenus' => $labelsMenus,
            'dataMenus' => $dataMenus,

            // NUEVO
            'labelsServicios' => $labelsServicios,
            'dataServicios' => $dataServicios,

            'presupuesto' => $evento->presupuesto,
            'gastado' => $gastado,
            'restante' => $evento->presupuesto - $gastado,
        ];
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

        $menu = Menu::findOrFail($request->menu_id);

        $nuevoCoste = $menu->precio_unitario * $request->cantidad;

        $costeActual = $this->calcularCosteEvento($evento);

        if (($costeActual + $nuevoCoste) > $evento->presupuesto) {
            return back()->with('error', ' Supera el presupuesto del evento');
        }

        // guardar menú
        if ($evento->menus()->wherePivot('id_menu', $request->menu_id)->exists()) {
            $evento->menus()->updateExistingPivot($request->menu_id, [
                'cantidad' => $request->cantidad,
            ]);
        } else {
            $evento->menus()->attach($request->menu_id, [
                'cantidad' => $request->cantidad,
            ]);
        }

        return back()->with('success', 'Menú añadido correctamente');
    }

    public function updateMenu(Request $request, Evento $evento, Menu $menu)
    {
        $user = Auth::user();

        if (!in_array($user->rol, ['admin', 'empleado'])) {
            abort(403);
        }

        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        // cantidad actual en BD
        $cantidadActual = $evento->menus()
            ->where('menu.id_menu', $menu->id_menu)
            ->first()
            ->pivot->cantidad;

        // coste actual de ese menú
        $costeActualMenu = $menu->precio_unitario * $cantidadActual;

        // nuevo coste
        $nuevoCosteMenu = $menu->precio_unitario * $request->cantidad;

        // coste total del evento SIN este menú
        $costeTotal = $this->calcularCosteEvento($evento) - $costeActualMenu;

        // comprobar si supera el presupuesto
        if (($costeTotal + $nuevoCosteMenu) > $evento->presupuesto) {
            return back()->with('error', 'Se supera el presupuesto');
        }

        // actualizar
        $evento->menus()->updateExistingPivot($menu->id_menu, [
            'cantidad' => $request->cantidad,
        ]);

        return back()->with('success', 'Cantidad actualizada correctamente');
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
            'menus.*' => 'exists:menu,id_menu',

            'cantidad' => 'nullable|array',
            'cantidad.*' => 'nullable|integer|min:1',

            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicios,id_servicio',

            'cantidad_servicio' => 'nullable|array',
            'cantidad_servicio.*' => 'nullable|integer|min:1',

            'num_mesas' => 'required|integer|min:1',
            'asientos_mesa' => 'required|integer|min:1',
        ];

        if ($user->rol !== 'cliente') {
            $rules['local_id'] = ['required', 'exists:locales,id_local'];
            $rules['tipo_id'] = ['required', 'exists:tipo_evento,id_tipo'];
            $rules['id_usuario'] = ['required', 'exists:usuarios,id_usuario'];
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {

            // CALCULAR COSTE ANTES
            $presupuesto = $request->presupuesto;
            $gastado = 0;

            // MENÚS
            foreach ($request->menus as $menuId) {
                $menu = Menu::find($menuId);
                $cantidad = $request->cantidad[$menuId] ?? 1;
                $gastado += $menu->precio_unitario * $cantidad;
            }

            // SERVICIOS
            if ($request->servicios) {
                foreach ($request->servicios as $servicioId) {
                    $servicio = Servicio::find($servicioId);
                    $cantidad = $request->cantidad_servicio[$servicioId] ?? 1;
                    $gastado += $servicio->precio_unitario * $cantidad;
                }
            }

            // LOCAL
            if ($request->local_id) {
                $local = Local::find($request->local_id);
                $gastado += $local->precio ?? 0;
            }

            // VALIDACIÓN FINAL PRESUPUESTO
            if ($gastado > $presupuesto) {
                return back()
                    ->withErrors([
                        'presupuesto' => 'El presupuesto se excede. Total: ' . $gastado . '€'
                    ])
                    ->withInput();
            }

            //  CREAR EVENTO
            if ($user->rol === 'cliente') {

                $evento = Evento::create([
                    'nombre_evento' => $request->nombre_evento,
                    'fecha' => $request->fecha,
                    'id_usuario' => $user->id_usuario,
                    'presupuesto' => $presupuesto,
                    'estado' => 'pendiente'
                ]);
            } else {

                $evento = Evento::create([
                    'nombre_evento' => $request->nombre_evento,
                    'fecha' => $request->fecha,
                    'id_usuario' => $request->id_usuario,
                    'id_local' => $request->local_id,
                    'id_tipo' => $request->tipo_id,
                    'presupuesto' => $presupuesto,
                    'estado' => 'confirmado'
                ]);
            }

            //  MENÚS
            foreach ($request->menus as $menuId) {
                $evento->menus()->attach($menuId, [
                    'cantidad' => $request->cantidad[$menuId] ?? 1
                ]);
            }

            // SERVICIOS
            if ($request->servicios) {
                foreach ($request->servicios as $servicioId) {

                    $cantidad = $request->cantidad_servicio[$servicioId] ?? 1;

                    $evento->servicios()->attach($servicioId, [
                        'cantidad' => $cantidad,
                        'precio_total' => Servicio::find($servicioId)->precio_unitario * $cantidad
                    ]);
                }
            }

            // INVITADOS
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
            //  MESAS
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

            DB::commit();

            return redirect()->route('eventos.index')
                ->with('success', 'Evento creado correctamente');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Error al crear el evento'])
                ->withInput();
        }
    }
    //Servicios
    //Añadir Servicios
    public function attachServicio(Request $request, Evento $evento)
    {
        $request->validate([
            'servicio_id' => 'required|exists:servicios,id_servicio',
            'cantidad' => 'required|integer|min:1',
        ]);

        $servicio = Servicio::findOrFail($request->servicio_id);

        $nuevoCoste = $servicio->precio_unitario * $request->cantidad;

        $costeActual = $this->calcularCosteEvento($evento);

        if (($costeActual + $nuevoCoste) > $evento->presupuesto) {
            return back()->with('error', 'Se supera el presupuesto del evento');
        }

        $evento->servicios()->syncWithoutDetaching([
            $servicio->id_servicio => [
                'cantidad' => $request->cantidad,
                'precio_total' => $nuevoCoste
            ]
        ]);

        return back()->with('success', 'Servicio añadido correctamente');
    }

    //Editar cantidad
    public function updateServicio(Request $request, Evento $evento, Servicio $servicio)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        // Obtener servicio actual del evento
        $servicioPivot = $evento->servicios
            ->firstWhere('id_servicio', $servicio->id_servicio);

        if (!$servicioPivot) {
            return back()->with('error', 'El servicio no está asociado al evento');
        }

        // Cantidad actual
        $cantidadActual = $servicioPivot->pivot->cantidad;

        // Coste actual de este servicio
        $costeActualServicio = $servicio->precio_unitario * $cantidadActual;

        // Nuevo coste
        $nuevoCosteServicio = $servicio->precio_unitario * $request->cantidad;

        // Coste total del evento SIN este servicio
        $costeTotal = $this->calcularCosteEvento($evento) - $costeActualServicio;

        // VALIDACIÓN PRESUPUESTO
        if (($costeTotal + $nuevoCosteServicio) > $evento->presupuesto) {
            return back()->with('error', 'Se supera el presupuesto del evento');
        }

        //  Actualizar
        $evento->servicios()->updateExistingPivot($servicio->id_servicio, [
            'cantidad' => $request->cantidad,
            'precio_total' => $nuevoCosteServicio
        ]);

        return back()->with('success', 'Servicio actualizado correctamente');
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

    //Eliminar evento
    public function destroy($id)
    {
        $user = auth()->user();

        // Solo admin y empleado pueden eliminar
        if (!in_array($user->rol, ['admin', 'empleado'])) {

            return redirect()->back()
                ->with('error', 'No tienes permisos para eliminar eventos.');
        }

        // Buscar evento
        $evento = Evento::findOrFail($id);

        // Eliminar evento
        $evento->delete();

        return redirect()->route('eventos.index')
            ->with('success', 'Evento eliminado correctamente.');
    }
    //Presupuesto restante del evento (presupuesto - coste)
    private function getPresupuestoRestante($evento)
    {
        return $evento->presupuesto - $this->calcularCosteEvento($evento);
    }
}
