<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\AreaRepository;
use Ultraware\Roles\Models\Permission;
use Ultraware\Roles\Models\Role;

class RolController extends Controller
{
    public function __construct(AreaRepository $areas, RoleRepository $roles){
        $this->middleware('auth');
        $this->areas = $areas;
        $this->roles = $roles;
    }

    public function index(){
        $roles = $this->roles->listRole();
        return view('app.rol.list',compact('roles'));
    }

    public function create(){
        $areas = $this->areas->allArea();
        return view('app.rol.create',compact('areas'));
    }
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|max:30',
            'slug' => 'required|unique:Roles',
            'description' => 'max:100',
            'area_id_rol' => 'required'
        ]);
        $data = $request->all();
        Role::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'level' => 1,
            'area_id'=>$data['area_id_rol']
        ]);
        return redirect()->to(route('roles'));
    }

    public function show(Role $rol){
        //$rol = Role::where('slug',$rol_slug)->first();
        return view('app.rol.detail',compact('rol'));
    }

    public function edit(Role $rol){
        $areas = $this->areas->allArea();
        $permissions = Permission::all();
        return view('app.rol.edit',compact('rol','areas','permissions'));
    }
    public function update(Request  $request,  Role $rol){
        $this->validate($request,[
            'name' => 'required|max:30',
            //'slug' => 'required|unique:Roles,slug,'.$rol->slug.',id',
            'description' => 'max:100',
            'area_id_rol' => 'required'
        ]);
        $data = $request->all();
        $rol->name = $data['name'];
        //$rol->slug = $data['slug'];
        $rol->description = $data['description'];
        $rol->level = 1;
        $rol->area_id=$data['area_id_rol'];
        $rol->save();
        return redirect()->to(route('roles'));
    }
    public function updatePermission(Request  $request,  Role $rol){
        $data = $request->all();
        $markPermision = array_where($data, function ($key, $value) {
            return  substr($key,0,strlen('permission_id_rol'))=='permission_id_rol';
        });
        $allPermissions = Permission::all();
        foreach($allPermissions as $onePermission){
            $find = false;
            foreach($markPermision as $idPerm){
                if($onePermission->id==$idPerm){
                    $find = true;
                }
            }
            if($find){
                $rol->attachPermission($onePermission);
            }else{
                $rol->detachPermission($onePermission);
            }
        }
        return redirect()->route('roles');

        /*$this->validate($request,[
            'name' => 'required|max:30',
            //'slug' => 'required|unique:Roles,slug,'.$rol->slug.',id',
            'description' => 'max:100',
            'area_id_rol' => 'required'
        ]);
        $data = $request->all();
        $rol->name = $data['name'];
        //$rol->slug = $data['slug'];
        $rol->description = $data['description'];
        $rol->level = 1;
        $rol->area_id=$data['area_id_rol'];
        $rol->save();
        return redirect()->to(route('roles'));*/
    }

    public function destroy(Role $rol){
        if ( $rol->users()->count() != 0) {
            return redirect()->to(route('roles'))
                ->withErrors(['mensaje'=>$rol->name.' no puede ser borrado mientras tenga usuarios asociados'])
                ->withInput();
        }
        else{
            $rol->delete();
            return redirect()->to(route('roles'));
        }
    }
}
