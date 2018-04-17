<?php

use App\Models\ApprobationFormat;
use App\Models\solicitudType;
use Illuminate\Database\Seeder;

class ApprobationFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //solicitud 1
        $solicitud1 = solicitudType::where('name','Cliente Nacional')->first();
        ApprobationFormat::create([
            'solicitude_type_id'=>$solicitud1->id,
            'order'=>1,
            'pattern_approver'=>'area.rank1',
            'wait'=>1,
            'required'=>1,
        ]);
        ApprobationFormat::create([
            'solicitude_type_id'=>$solicitud1->id,
            'order'=>2,
            'pattern_approver'=>'inf.gen',
            'wait'=>1,
            'required'=>1,
        ]);
        ApprobationFormat::create([
            'solicitude_type_id'=>$solicitud1->id,
            'order'=>3,
            'pattern_approver'=>'cont.gen',
            'wait'=>1,
            'required'=>1,
        ]);
        //solicitud 2
        $solicitud2 = solicitudType::where('name','Cliente Extranjero')->first();
        ApprobationFormat::create([
            'solicitude_type_id'=>$solicitud2->id,
            'order'=>1,
            'pattern_approver'=>'area.rank1',
            'wait'=>1,
            'required'=>1,
        ]);
        ApprobationFormat::create([
            'solicitude_type_id'=>$solicitud2->id,
            'order'=>2,
            'pattern_approver'=>'inf.gen',
            'wait'=>1,
            'required'=>1,
        ]);
        ApprobationFormat::create([
            'solicitude_type_id'=>$solicitud2->id,
            'order'=>3,
            'pattern_approver'=>'cont.gen',
            'wait'=>1,
            'required'=>1,
        ]);
        //solicitud 3
        $solicitud3 = solicitudType::where('name','Proveedor Nacional')->first();
        ApprobationFormat::create([
            'solicitude_type_id'=>$solicitud3->id,
            'order'=>1,
            'pattern_approver'=>'area.rank1',
            'wait'=>1,
            'required'=>1,
        ]);
        ApprobationFormat::create([
            'solicitude_type_id'=>$solicitud3->id,
            'order'=>2,
            'pattern_approver'=>'inf.gen',
            'wait'=>1,
            'required'=>1,
        ]);
        ApprobationFormat::create([
            'solicitude_type_id'=>$solicitud3->id,
            'order'=>3,
            'pattern_approver'=>'cont.gen',
            'wait'=>1,
            'required'=>1,
        ]);
        //solicitud 4
        $solicitud4 = solicitudType::where('name','Proveedor Extranjero')->first();
        ApprobationFormat::create([
            'solicitude_type_id'=>$solicitud4->id,
            'order'=>1,
            'pattern_approver'=>'area.rank1',
            'wait'=>1,
            'required'=>1,
        ]);
        ApprobationFormat::create([
            'solicitude_type_id'=>$solicitud4->id,
            'order'=>2,
            'pattern_approver'=>'inf.gen',
            'wait'=>1,
            'required'=>1,
        ]);
        ApprobationFormat::create([
            'solicitude_type_id'=>$solicitud4->id,
            'order'=>3,
            'pattern_approver'=>'cont.gen',
            'wait'=>1,
            'required'=>1,
        ]);
    }
}
