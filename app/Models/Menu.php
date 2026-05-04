<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Evento;

class Menu extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    public $timestamps = false;

    public function eventos()
    {
        return $this->belongsToMany(
            Evento::class,
            'menu_evento',
            'id_menu',
            'id_evento'
        )->withPivot('cantidad');
    }
}