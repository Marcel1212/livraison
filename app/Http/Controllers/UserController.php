<?php

namespace App\Http\Controllers;


use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\Envoisms;
use App\Models\Agence;
use App\Models\User;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = User::with('agence:num_agce,lib_agce')
                ->where([['flag_demission_users', '=', false], ['flag_admin_users', '=', false]])
                ->get();
       //dd($data);
        return view('users.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where([['id', '!=', 4]])->get()->pluck('name', 'name');
        $Entite = Agence::where([['flag_agce', '=', true]])->get();
        foreach ($Entite as $comp) {
            $Entite .= "<option  value='" . $comp->num_agce . "'   > " . $comp->lib_agce . " </option>";
        }
        return view('users.create', compact('roles', 'Entite'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $key = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $idutil = Auth::user()->id;
        /*$this->validate($request, [
            'name' => 'required',
            'login_users' => 'required|login_users|unique:users,login_users',
            'email' => 'email|unique:users,email',
            'cel_users' => 'required'
        ]);*/
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
            ->with('success', 'Succes : Enregistrement reussi');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->first();
        //$userRole = $user->roles->pluck('name', 'name')->all();
        $Entite = Agence::where([['flag_agce', '=', true]])->get();
        foreach ($Entite as $comp) {
            if ($user->num_agce == $comp->num_agce) {$val = 'selected="selected"'; } else { $val = '';}
            $Entite .= "<option  value='" . $comp->num_agce . "' $val  > " . $comp->lib_agce . " </option>";
        }

        $Roless = Role::get();

        //dd($userRole);
        foreach ($Roless as $comp) {
            if ($userRole == $comp->name) {$val = 'selected="selected"'; } else { $val = '';}
            $Roless .= "<option  value='" . $comp->name . "' $val  > " . $comp->name . " </option>";
        }
        return view('users.edit', compact('user', 'roles', 'userRole', 'Entite','Roless'));
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
        /*$validatedData = $request->validate([
            'name' => 'required',
            'email' => 'email|unique:users,email,' . $id,
            'login_users' => 'required|login_users|unique:users,login_users,' . $id,
            'roles' => 'required'
        ]);*/
        $user = User::find($id);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
            ->with('success', 'Succes : Enregistrement reussi');
    }


}
