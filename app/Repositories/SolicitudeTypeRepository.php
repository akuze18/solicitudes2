<?php

namespace App\Repositories;

use App\Models\solicitudType;

class SolicitudeTypeRepository
{
    public function allTypes()
    {
        return solicitudType::OrderBy('orderBy')->all();
    }

    public function listType()
    {
        return solicitudType::OrderBy('orderBy')->paginate(20);
    }

    /**
     * @param String $type_name
     * @return \App\Menu
     */
    public function byName($type_name){
        return solicitudType::where('name',$type_name)->firstOrFail();
    }

    /**
     * @param Int $type_id
     * @return \App\Menu
     */
    public function byId($type_id){
        return solicitudType::where('id',$type_id)->firstOrFail();
    }
}