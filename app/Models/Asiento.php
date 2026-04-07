<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    protected $table = 'asiento';
    protected $primaryKey = 'id_asiento';
    public $timestamps = false;
}
