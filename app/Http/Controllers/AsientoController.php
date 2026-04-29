<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asiento;
use App\Models\Invitado;

class AsientoController extends Controller
{
    public function asignar(Request $request)
    {
        Asiento::where('id_invitado', $request->invitado_id)
            ->update(['id_invitado' => null]);

        $asiento = Asiento::where('id_asiento', $request->asiento_id)->first();

        $asiento->id_invitado = $request->invitado_id;
        $asiento->save();

        return response()->json(['success' => true]);
    }

    public function desasignar(Request $request)
    {
        Asiento::where('id_invitado', $request->invitado_id)
            ->update(['id_invitado' => null]);

        return response()->json(['success' => true]);
    }
}
