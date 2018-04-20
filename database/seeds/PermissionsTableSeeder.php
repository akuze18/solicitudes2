<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = ['Create','Delete','List','See','Edit','External'];
        $models = ['User','Role','Area','Permission','Solicitude','Approbation','solicitudeType','solicitudeAction','approbationFormat','menu'];
        $role = Role::where('name','Admin')->first();
        foreach($models as $model){
            foreach($actions as $action){
                $name = strtolower($action.'.'.$model) ;
                $counter = Permission::where('name',$name)->count();
                if($counter==0){
                    $newPermission = Permission::create([
                        'name' => $name,
                        'model' => $model
                    ]);
                }else{
                    $newPermission = Permission::where('name',$name)->first();
                }
                $role->givePermissionTo($newPermission); // permission attached to a role
            }
        }
        //permisos para otros roles
        $roles = Role::where('name','<>','admin')->get();
        foreach($roles as $sRole){
            $parn = explode('.',$sRole->name);
            if($parn[1]=='gen'){
                //si es jefe, se añaden todos los permisos de aprobacion
                $approbationP = Permission::where('model','Approbation')
                    ->where('name','like','external')
                    ->get();
                $sRole->givePermissionTo($approbationP);
            }
            elseif($parn[1]=='asist'){
                //si es asistente, se añaden todos los permisos de solicitud
                $solicitudeP = Permission::where('model','Solicitude')->get();
                $sRole->givePermissionTo($solicitudeP);
            }
        }
    }
}
