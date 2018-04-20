<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 02/08/2017
 * Time: 12:11
 */

namespace App\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepository {
    public function allRole(){
        return Role::where('name','!=','admin')->orderBy('name')->get()->sortBy('area_id');
    }
    public function listRole(){
        return Role::where('name','!=','admin')->orderBy('name')->paginate(20);
    }

    /**
     * @param $role_id
     * @return \Spatie\Permission\Models\Role
     */
    public function byId($role_id){
        return Role::where('id',$role_id)->first();
    }

    /**
     * @param $role_name
     * @return \Spatie\Permission\Models\Role
     */
    public function byName($role_name){
        return Role::where('name',$role_name)->first();
    }
}