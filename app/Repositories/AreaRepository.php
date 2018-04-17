<?php

namespace App\Repositories;

use App\Models\Area;

class AreaRepository
{
    public function allArea()
    {
        return Area::orderBy('name', 'asc')->where('sname','<>','sistem')->get();
    }

    public function listArea()
    {
        return Area::orderBy('name', 'asc')->where('sname','<>','sistem')->paginate(20);
    }

    public function byName($area_name){
        return Area::where('name',$area_name)->firstOrFail();
    }
    public function byId($area_id){
        return Area::where('id',$area_id)->firstOrFail();
    }
}