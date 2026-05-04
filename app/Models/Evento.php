<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Usuario;
use App\Models\TipoEvento;
use App\Models\Invitado;
use App\Models\Mesa;
use App\Models\Local;
use App\Models\Menu;

class Evento extends Model
{
    protected $table = 'eventos';
    protected $primaryKey = 'id_evento';
    public $timestamps = false;

    protected $fillable = [
        'nombre_evento',
        'fecha',
        'descripcion',
        'experiencia',
        'id_usuario',
        'id_tipo',
        'id_local',
        'estado',
        'presupuesto'
    ];

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

    public function local()
    {
        return $this->belongsTo(Local::class, 'id_local', 'id_local');
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

    public function servicios()
{
    return $this->belongsToMany(
        \App\Models\Servicio::class,
        'servicios_contratados',   
        'id_evento',              
        'id_servicio'         
    )->withPivot('cantidad', 'precio_total');
}
}
