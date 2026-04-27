<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locales';
    protected $primaryKey = 'id_local';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'direccion',
        'capacidad',
        'telefono',
        'descripcion'
    ];
}
