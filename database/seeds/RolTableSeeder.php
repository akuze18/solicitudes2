<?php

use App\Models\Area;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Rol de Administrador del Sistema
        $system_area = Area::where('name','Sistema')->first();
        Role::create([
            'name' => 'admin',
            'description' => 'Administrador',
            'area_id'=>$system_area->id
        ]);/**/
        //Otros Roles
        $areas = Area::where('name','<>','Sistema')->get();
        foreach($areas as $area){
            $jefe = ($area->name=='Contabilidad'?'Contador General':'Jefe');
            Role::create([
                'name' => $area->sname.'.gen',
                'description' => $jefe.' '.$area->name,
                'area_id'=>$area->id
            ]);
            Role::create([
                'name' => $area->sname.'.asist',
                'description' => 'Asistente de '.$area->name,
                'area_id'=>$area->id
            ]);
        }
    }
}
