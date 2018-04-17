<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Ultraware\Roles\Models\Permission;
use Ultraware\Roles\Models\Role;

class PermissionController extends Controller
{
    private $actions;
    private $roles;
    public function __construct(RoleRepository $roleRepository){
        $this->middleware('auth');
        $this->actions= [
            (object)array('id'=>'Create','namefull'=>'Create'),
            (object)array('id'=>'Delete','namefull'=>'Delete'),
            (object)array('id'=>'List','namefull'=>'List'),
            (object)array('id'=>'See','namefull'=>'See'),
            (object)array('id'=>'Edit','namefull'=>'Edit'),
        ];
        $this->roles = $roleRepository;
    }
    public function index(){
        $permissions = Permission::orderBy('model')->orderBy('name')->paginate(20);
        return view('app.permission.list',compact('permissions'));
    }
    //No puedo crear permisos desde la aplicación ya que estan asociados a modelos (que eson estaticos)
    /*public function detail(){
        $roles = Role::where('slug','!=','admin')->get()->sortBy('area_id');
        $actions = $this->actions;
        return view('app.permission.detail',compact('roles','actions'));
    }
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|max:50',
            'description' => 'required|max:100',
        ]);
        $data = $request->all();
        $roles = array_where($data, function ($key, $value) {
            return  substr($key,0,strlen('rol_id_option'))=='rol_id_option';
        });
        $option = Option::detail([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        foreach($roles as $rol){
            $option->roles()->attach($rol);
        }


        return redirect()->to('options');
    }
*/
    public function show(Permission $permission){
        return view('app.permission.detail',compact('permission'));
    }

    public function edit(Permission $permission){
        $roles = $this->roles->allRole();// Role::where('slug','!=','admin')->get()->sortBy('area_id');
        return view('app.permission.edit',compact('permission','roles'));
    }

    public function update(Request $request,Permission $permission){
        $data = $request->all();
        $markRoles = array_where($data, function ($key, $value) {
            return  substr($key,0,strlen('rol_id_permission'))=='rol_id_permission';
        });
        $allRoles = $this->roles->allRole();
        foreach($allRoles as $oneRole){
            $find = false;
            foreach($markRoles as $idRol){
                if($oneRole->id==$idRol){
                    $find = true;
                }
            }
            if($find){
                $oneRole->attachPermission($permission);
            }else{
                $oneRole->detachPermission($permission);
            }
        }
        return redirect()->route('permissions');
    }
    //No puedo borrar permisos ya que son necesarios al menos por administrador
    /*public function destroy(Permission $permission){
        if ($permission->roles()->count() != 0) {
            return redirect()->route('permissions')
                ->withErrors(['mensaje'=>$permission->name.' no puede ser borrado mientras tenga roles asociados'])
                ->withInput();
        }
        else{
            $permission->delete();
            return redirect()->route('permissions');
        }
    }*/
}
