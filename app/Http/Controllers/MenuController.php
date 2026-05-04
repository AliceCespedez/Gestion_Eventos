<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * ======================
     * CRUD MENÚ GLOBAL
     * ======================
     */

    public function index()
    {
        return view('menus.index', [
            'menus' => Menu::all()
        ]);
    }

    public function create()
    {
        return view('menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo_menu' => 'nullable|string|max:100',
            'precio_unitario' => 'required|numeric|min:0'
        ]);

        Menu::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'tipo_menu' => $request->tipo_menu,
            'precio_unitario' => $request->precio_unitario
        ]);

        return redirect()->route('menus.index')
            ->with('success', 'Menú creado correctamente');
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo_menu' => 'nullable|string|max:100',
            'precio_unitario' => 'required|numeric|min:0'
        ]);

        $menu->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'tipo_menu' => $request->tipo_menu,
            'precio_unitario' => $request->precio_unitario
        ]);

        return redirect()->route('menus.index')
            ->with('success', 'Menú actualizado correctamente');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return back()->with('success', 'Menú eliminado correctamente');
    }
}