<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepository;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Ultraware\Roles\Models\Role;

class UserController extends Controller
{
    public function __construct(RoleRepository $roleRepository){
        $this->middleware('auth');
        $this->role = $roleRepository;
    }
    public function index(){
        $users = User::orderBy('first_name')->orderBy('last_name')->paginate(20);
        return view('app.user.list',compact('users'));
    }
    public function create(){
        $roles = $this->role->allRole();
        return view('app.user.create',compact('roles'));
    }
    public function store(Request $request){
        $this->validate($request,[
            'username' => 'required|unique:users',
            'rut' => 'required|max:30|unique:users',
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'rol_id_user' => 'required',
        ]);
        $data = $request->all();
        $newUser = User::create([
            'username' => $data['username'],
            'rut' => $data['rut'],
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $newUser->attachRole($data['rol_id_user']);
        return redirect()->to(route('users'));
    }
    public function show(User $user){

        return view('app.user.detail',compact('user'));
    }
    public function edit(User $user){
        //$user = User::where('username',$username)->firstOrFail();
        $roles = $this->role->allRole();
        return view('app.user.edit',compact('user','roles'));
    }
    public function update(Request $request, User $user){
        $this->validate($request,[
            'rut' => 'required|max:30|unique:users,rut,'.$user->id,
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'rol_id_user' => 'required',
        ]);
        $user->rut = $request->get('rut');
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->save();
        $rol_id = $request->get('rol_id_user');
        if($user->roles[0]->id != $rol_id){
            $user->detachRole($user->roles[0]);
        }
        $user->attachRole($rol_id);
        return redirect()->route('users');
    }

    public function destroy($id)
    {
        //TODO: Eliminar usuarios
        return redirect()->back()->withErrors(['mensaje'=>'Opción no disponible, falta incorporar']);
    }
}
