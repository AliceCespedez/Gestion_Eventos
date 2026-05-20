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


   public function getSeccionesMenuAttribute()
    {
        $descripcion = $this->descripcion;
        $secciones = [];
        
        // busca e texto entre ## ##
        $patron = '/##([^#]+)##/';
        $partes = preg_split($patron, $descripcion, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        
        // texto, tttulo, texto, titulo, texto... así que los títulos -> imapres
        for ($i = 1; $i < count($partes); $i += 2) {
            $titulo = trim($partes[$i]); //titulo
            
            // texto: (indice i+1) o vacio si no hay
            $contenido = isset($partes[$i + 1]) ? trim($partes[$i + 1]) : '';
            
            if (!empty($contenido)) {
                $lineas = explode("\n", $contenido);
                $lineas = array_map('trim', $lineas);
                $lineas = array_filter($lineas);
                
                if (!empty($lineas)) {
                    $secciones[] = [
                        'titulo' => $titulo,
                        'items' => $lineas
                    ];
                }
            }
        }
        
        return $secciones;
    }

    /*
    public function getSeccionesMenuAttribute()
    {
        $descripcion = $this->descripcion;
        $secciones = [];
        
        $patron = '/(Entrantes|Plato principal \([^)]+\)|Bebida|Postre)/i';
        $partes = preg_split($patron, $descripcion, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        
        for ($i = 0; $i < count($partes); $i += 2) {
            if (isset($partes[$i + 1])) {
                $titulo = trim($partes[$i]);
                $contenido = trim($partes[$i + 1]);
                
                // Convertir líneas en array
                $lineas = explode("\n", $contenido);
                $lineas = array_map('trim', $lineas);
                $lineas = array_filter($lineas);
                
                $secciones[] = [
                    'titulo' => $titulo,
                    'items' => $lineas
                ];
            }
        }
        
        return $secciones;
    }
    */
}