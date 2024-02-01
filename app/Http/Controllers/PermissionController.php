<?php

namespace App\Http\Controllers;

use App\Models\Permissions;
use App\Models\Sousmenus;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Session;


class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->middleware('can:permission-create');
        //$this->authorize("can:permission-create", Permissions::class);
        $data = Permissions::all();
        return view('permissions.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $SousMenu = DB::table('sousmenu')->where('is_valide', '=', true)->orderBy('libelle',)->get();
        $SousMenuList = "<option value='' > -- Sélectionner --</option>";
        foreach ($SousMenu as $comp) {
            $SousMenuList .= "<option value='" . $comp->id_sousmenu . "'   >" . strtoupper($comp->libelle) . " </option>";
        }
        return view('permissions.create', compact('SousMenuList'));
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
            'name' => 'required',
            'lib_permission' => 'required',
            'id_sousmenu' => 'required',
        ]);
        Permissions::create([
            'name' => $request->input('name'),
            'lib_permission' => $request->input('lib_permission'),
            'id_sousmenu' => $request->input('id_sousmenu'),
            'is_valide' => $request->input('is_valide'),
            'guard_name' => 'web'
        ]);
        return redirect()->route('permissions.index')
            ->with('success', 'Succes : Enregistrement réussi.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Permissions $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permissions $permission)
    {
        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Permissions $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permissions $permission)
    {
        $SousMenu = Sousmenus::where('is_valide', '=', true)->orderBy('libelle',)->get();
        $SousMenuList = "<option value='' > -- Sélectionner --</option>";
        $val = '';
        foreach ($SousMenu as $comp) {
            if ($comp->id_sousmenu == $permission->id_sousmenu)
                $val = 'selected';
            $SousMenuList .= "<option value='" . $comp->id_sousmenu . "'  $val >" . strtoupper($comp->libelle)." [ ".$comp->menu->menu." ] ". " </option>";
        }
        return view('permissions.edit', compact('permission', 'SousMenuList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Permissions $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permissions $permission)
    {
        request()->validate([
            'name' => 'required',
            'lib_permission' => 'required',
            'id_sousmenu' => 'required',
        ]);
        $permission->update([
            'name' => $request->input('name'),
            'lib_permission' => $request->input('lib_permission'),
            'id_sousmenu' => $request->input('id_sousmenu'),
            'is_valide' => $request->input('is_valide')
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Succes : Mise à jour réussie.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Permissions $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permissions $permission)
    {
        //$permission->delete();


        return redirect()->route('permissions.index')
            ->with('success', 'Permission deleted successfully');
    }
}
