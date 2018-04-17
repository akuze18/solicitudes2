<?php

use App\Models\solicitudType;
use Illuminate\Database\Seeder;

class solicitudeTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        solicitudType::create(['name'=>'Proveedor Nacional','orderBy'=>1]);
        solicitudType::create(['name'=>'Proveedor Nacional Materia Prima','orderBy'=>2]);
        solicitudType::create(['name'=>'Proveedor Extranjero','orderBy'=>3]);
        solicitudType::create(['name'=>'Proveedor Extranjero Materia Prima','orderBy'=>4]);
        solicitudType::create(['name'=>'Cliente Nacional','orderBy'=>5]);
        solicitudType::create(['name'=>'Cliente Extranjero','orderBy'=>6]);
        solicitudType::create(['name'=>'Artículo','orderBy'=>7]);
        solicitudType::create(['name'=>'Usuario','orderBy'=>8]);
    }
}
