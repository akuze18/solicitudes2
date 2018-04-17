<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 28/07/2017
 * Time: 11:05
 */

namespace App\Repositories;


use App\Models\Estado;

class EstadoRepository {
    public function Aprobado(){
        return Estado::where('slug','A')->first();
    }
    public function Objetado(){
        return Estado::where('slug','O')->first();
    }
    public function Rechazado(){
        return Estado::where('slug','R')->first();
    }
    public function Enviado(){
        return Estado::where('slug','E')->first();
    }
    public function Espera(){
        return Estado::where('slug','T')->first();
    }
    public function SolEstado($estado){
        return Estado::where('solicitude',$estado)->first();
    }
}