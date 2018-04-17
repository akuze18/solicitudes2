<?php

namespace App\Repositories;

class AllRepositories
{
    private $repositories;

    public function __construct(){
        $this->repositories = [
            'area' => new AreaRepository(),
            'estado' => new EstadoRepository(),
            'menu'=> new MenuRepository(),
            'role' => new RoleRepository(),
            'sol_type' => new SolicitudeTypeRepository()
        ];
    }

    /**
     * @return \App\Repositories\AreaRepository
     */
    public function area(){return $this->repositories['area'];}

    /**
     * @return \App\Repositories\EstadoRepository
     */
    public function estado(){return $this->repositories['estado'];}

    /**
     * @return \App\Repositories\MenuRepository
     */
    public function menu(){return $this->repositories['menu'];}

    /**
     * @return \App\Repositories\RoleRepository
     */
    public function role(){return $this->repositories['role'];}

    /**
     * @return \App\Repositories\SolicitudeTypeRepository
     */
    public function solType(){return $this->repositories['sol_type'];}
}