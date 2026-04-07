<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioContratado extends Model
{
    protected $table = 'servicios_contratados';
    protected $primaryKey = 'id_contratacion';
    public $timestamps = false;
}
