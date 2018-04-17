<?php

namespace App\Models;

use App\Repositories\RoleRepository;
use Ultraware\Roles\Models\Role;

class Area extends MyModel
{
    protected $table = 'areas';
    protected $fillable = ['name','sname','rank1','rank2','rank3'];

    public function roles(){
        return $this->hasMany(Role::class);
    }

    //Rangos Especiales Generales
    public function getRango1Attribute(){
        $rango = $this->Rango($this->rank1);
        return is_null($rango) ? '' : $rango->Namefull;
    }
    public function getRango2Attribute(){
        $rango = $this->Rango($this->rank2);
        return is_null($rango) ? '' : $rango->Namefull;
    }
    public function getRango3Attribute(){
        $rango = $this->Rango($this->rank3);
        return is_null($rango) ? '' : $rango->Namefull;

    }

    public function RangoId($role_slug){
        $rango = $this->Rango($role_slug);
        return is_null($rango) ? null : $rango->id;

    }

    public function Rango($role_slug){
        $rango = new RoleRepository();
        return $rango->bySlug($role_slug);

    }
}
