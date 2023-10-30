<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\Sousmenus;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Session;
use Spatie\Permission\Models\Role;

class SousmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = DB::table('sousmenu as s')
            ->select('s.id_sousmenu', 's.sousmenu',  's.is_valide', 's.priorite_sousmenu', 's.libelle', 'm.menu')
            ->join('menu as m', 'm.id_menu', '=', 's.menu_id_menu', 'inner')
            ->get();
        return view('sousmenus.index', compact('data',));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuss = DB::table('menu as m')
            ->select( 'm.id_menu', 'm.menu')
            ->Where('m.is_valide','=',true)
            ->orderBy('m.menu')
            ->get();
        $menus = "<option selected disabled>-- Sélectionner --</option>";
        foreach ($menuss as $comp) {
            $menus .= "<option value='" . $comp->id_menu . "'>" . $comp->menu . "</option>";
        }
        return view('sousmenus.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Sousmenus::create(
            ['menu_id_menu' => $request->input('menus'),
                'sousmenu' => $request->input('sousmenu'),
                'libelle' => $request->input('libelle'),
                'priorite_sousmenu' => $request->input('priorite_sousmenu'),
                'is_valide' => $request->input('is_valide')
            ]);
        return redirect()->route('sousmenus.index')
            ->with('success', ' Succes : Enregistrement reussi.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param \App\Models\Sousmenus $sousmenus
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sousmenus = Sousmenus::where([['id_sousmenu', '=', $id]])->first();
        return view('sousmenus.show', compact( 'sousmenus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $sm = DB::table('sousmenu as s')
            ->select('s.id_sousmenu', 's.menu_id_menu', 's.is_valide','s.sousmenu', 's.priorite_sousmenu', 's.libelle', 'm.menu')
            ->join('menu as m', 'm.id_menu', '=', 's.menu_id_menu', 'inner')
            ->where([['s.id_sousmenu', '=', $id]])->first();
        $selectsousmenu = $sm->menu;
        $menuss = Menus::get();
        $menus = "<option selected value='$sm->menu_id_menu'>$selectsousmenu</option>";
        foreach ($menuss as $comp) {
            $menus .= "<option value='" . $comp->id_menu . "'>" . $comp->menu . "</option>";
        }

        $sousmenus = Sousmenus::where([['id_sousmenu', '=', $id]])->first();
        return view('sousmenus.edit', compact('menus', 'sousmenus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Sousmenus::where(['id_sousmenu' => $id])
                    ->update(
                        ['menu_id_menu' => $request->input('menus'),
                            'sousmenu' => $request->input('sousmenu'),
                            'libelle' => $request->input('libelle'),
                            'priorite_sousmenu' => $request->input('priorite_sousmenu'),
                            'is_valide' => $request->input('is_valide')
                        ]);
        return redirect()->route('sousmenus.index')
            ->with('success', 'Succes : Enregistrement reussi.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
