<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 02/08/2017
 * Time: 12:11
 */

namespace App\Repositories;

use Ultraware\Roles\Models\Role;

class RoleRepository {
    public function allRole(){
        return Role::where('slug','!=','admin')->orderBy('slug')->get()->sortBy('area_id');
    }
    public function listRole(){
        return Role::where('slug','!=','admin')->orderBy('slug')->paginate(20);
    }

    /**
     * @param $role_id
     * @return \Ultraware\Roles\Models\Role
     */
    public function byId($role_id){
        return Role::where('id',$role_id)->first();
    }

    /**
     * @param $role_slug
     * @return \Ultraware\Roles\Models\Role
     */
    public function bySlug($role_slug){
        return Role::where('slug',$role_slug)->first();
    }
}