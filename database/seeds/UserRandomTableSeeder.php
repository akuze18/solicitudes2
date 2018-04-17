<?php

use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Role;

class UserRandomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::where('slug', '!=', 'admin')->get();
        $users = factory(User::class)->times(5)->make();  //metodo make crea un registro, pero no lo guarda directamente enla base de datos
        foreach($users as $user){
            $user_role = $roles->random();
            $user->attachRole($user_role);
        }
    }
}
