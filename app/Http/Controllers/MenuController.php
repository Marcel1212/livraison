<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Session;
use Spatie\Permission\Models\Role;

class MenuController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Menus::all();
        return view('menus.index', compact('data',));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('menus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         request()->validate([
            'menu' => 'required',
            'priorite_menu' => 'required',
        ]);
        Menus::create([
            'menu' => $request->input('menu'),
            'icone' => $request->input('icone'),
            'priorite_menu' => $request->input('priorite_menu'),
            'guard_name' => 'web',
            'is_valide' => $request->input('is_valide')
        ]);

        return redirect()->route('menus.index')
            ->with('success', 'Succes : Enregistrement réussi.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Menus $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menus $menu)
    {

        return view('menus.show', compact( 'menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Menus $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menus $menu)
    {
        return view('menus.edit', compact(  'menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menus $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menus $menu)
    {
        request()->validate([
            'menu' => 'required',
            'priorite_menu' => 'required',
        ]);
        $menu->update([
            'icone' => $request->input('icone'),
            'priorite_menu' => $request->input('priorite_menu'),
            'menu' => $request->input('menu'),
            'is_valide' => $request->input('is_valide')
        ]);
        return redirect()->route('menus.index')
            ->with('success', 'Succes : Enregistrement réussi.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Menus $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menus $menu)
    {
       // $menu->delete();

        return redirect()->route('menus.index')
            ->with('success', 'Menu deleted successfully');
    }

}
