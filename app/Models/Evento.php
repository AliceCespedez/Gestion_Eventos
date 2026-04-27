<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';
    protected $primaryKey = 'id_evento';
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoEvento::class, 'id_tipo', 'id_tipo');
    }

    public function invitados()
    {
        return $this->hasMany(Invitado::class, 'id_evento', 'id_evento');
    }

    public function mesas()
    {
        return $this->hasMany(Mesa::class, 'id_evento', 'id_evento');
    }

    public function servicios()
    {
        return $this->belongsToMany(
            Servicio::class,
            'servicios_contratados',
            'id_evento',
            'id_servicio',
            'id_evento',
            'id_servicio'
        )->withPivot('cantidad', 'precio_total');
    }

    public function local()
    {
        return $this->belongsTo(\App\Models\Local::class, 'id_local', 'id_local');
    }

    public function admin()
    {

        $eventos = Evento::with(['tipo', 'usuario'])->get();

        return view('admin', compact('eventos'));
    }
    public function menus()
    {
        return $this->belongsToMany(
            Menu::class,
            'menu_evento',
            'id_evento',
            'id_menu'
        )->withPivot('cantidad');
    }
}
