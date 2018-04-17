<?php

use App\Models\solicitudType;
use App\Models\solicitudAction;
use Illuminate\Database\Seeder;


class solicitudeActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = solicitudType::all();
        foreach($tipos as $tipo){
            $posicion = 1;
            solicitudAction::create([
                'code'=>'create',
                'name'=>'Crear/Nuevo',
                'orderBy'=>$posicion,
                'type'=>$tipo->id
            ]);
            $posicion = 2;
            solicitudAction::create([
                'code'=>'edit',
                'name'=>'Modificar',
                'orderBy'=>$posicion,
                'type'=>$tipo->id
            ]);
            $posicion = 3;
            if($tipo->name=='Usuarios'){
                solicitudAction::create([
                    'code'=>'suspend',
                    'name'=>'Suspender',
                    'orderBy'=>$posicion,
                    'type'=>$tipo->id
                ]);
            }else{
                solicitudAction::create([
                    'code'=>'down',
                    'name'=>'Baja/Eliminar',
                    'orderBy'=>$posicion,
                    'type'=>$tipo->id
                ]);
            }
        }
    }
}
