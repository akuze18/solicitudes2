<?php

use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado1 = Estado::create([
            'slug'=>'A','name'=>'Aprobadas','solicitude'=>'APROBADO','approbation'=>'Aprobado'
        ]);
        $estado2 = Estado::create([
            'slug'=>'O','name'=>'Objetadas','solicitude'=>'OBJETADO','approbation'=>'Objetado'
        ]);
        $estado3 = Estado::create([
            'slug'=>'R','name'=>'Rechazadas', 'solicitude'=>'RECHAZADO', 'approbation'=>'Rechazado'
        ]);
        $estado4 = Estado::create([
            'slug'=>'E','name'=>'Enviadas', 'solicitude'=>'ENVIADO', 'approbation'=>'Pendiente'
        ]);
        $estado5 = Estado::create([
            'slug'=>'T','name'=>'Trabajo', 'solicitude'=>'ESPERA', 'approbation'=>'En Espera'
        ]);
    }
}
