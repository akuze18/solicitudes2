<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(AreaTableSeeder::class);
        $this->call(RolTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(solicitudeTypeTableSeeder::class);
        $this->call(solicitudeActionSeeder::class);
        $this->call(solicitudeFormatSeeder::class);
        $this->call(EstadoTableSeeder::class);
        $this->call(ApprobationActionSeeder::class);
        $this->call(ApprobationFormatSeeder::class);
        Model::reguard();
    }
}
