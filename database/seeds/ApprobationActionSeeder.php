<?php

use App\Models\ApprobationAction;
use Illuminate\Database\Seeder;

class ApprobationActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApprobationAction::create(['description'=>'Aprobar', 'status'=>1]);
        ApprobationAction::create(['description'=>'Objetar', 'status'=>2]);
        ApprobationAction::create(['description'=>'Rechazar', 'status'=>3]);
        ApprobationAction::create(['description'=>'Pendiente', 'status'=>4]);
        ApprobationAction::create(['description'=>'Esperar', 'status'=>5]);
    }
}
