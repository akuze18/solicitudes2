<?php

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create(['name' => 'Sistema','sname' => 'sistem', 'rank1'=>'','rank2'=>'','rank3'=>'']);
        Area::create(['name' => 'Informática','sname' => 'inf','rank1'=>'adm.gen','rank2'=>'adm.gen','rank3'=>'adm.gen']);
        Area::create(['name' => 'Contabilidad','sname' => 'cont','rank1'=>'adm.gen','rank2'=>'adm.gen','rank3'=>'adm.gen']);
        Area::create(['name' => 'Administración','sname' => 'adm','rank1'=>'adm.gen','rank2'=>'adm.gen','rank3'=>'adm.gen']);
        Area::create(['name' => 'Producción','sname' => 'prod','rank1'=>'prod.gen','rank2'=>'prod.gen','rank3'=>'prod.gen']);
    }
}
