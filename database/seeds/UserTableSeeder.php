<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sysRole = Role::where('name','admin')->first();
        $sysUsername = 'admin';
        $sysUser = User::create([
            'rut' => '11111',
            'username' => $sysUsername,
            'first_name' => 'Administrador',
            'last_name' => 'Sistema',
            'email' => $sysUsername.'@'.env('COMP_MAIL_DOMAIN','example.com'),
            'password' => Hash::make('123456'),
        ]);
        $sysUser->assignRole($sysRole);

        $myRole = Role::where('name','inf.asist')->first();
        $username = 'aquispe';
        $myUser = User::create([
            'rut' => '151062180',
            'username' => $username,
            'first_name' => 'Ariel',
            'last_name' => 'Quispe',
            'email' => $username.'@nipponchile.cl',
            'password' => Hash::make('123456'),
        ]);
        $myUser->assignRole($myRole);

        $myRole = Role::where('name','inf.gen')->first();
        $username = 'rgallardo';
        $myUser = User::create([
            'rut' => '15290651K',
            'username' => $username,
            'first_name' => 'Rolando',
            'last_name' => 'Gallardo',
            'email' => $username.'@nipponchile.cl',
            'password' => Hash::make('123456'),
        ]);
        $myUser->assignRole($myRole);

        $myRole = Role::where('name','cont.asist')->first();
        $username = 'mpinones';
        $myUser = User::create([
            'rut' => '141400886',
            'username' => $username,
            'first_name' => 'Michael',
            'last_name' => 'Piñones',
            'email' => $username.'@nipponchile.cl',
            'password' => Hash::make('123456'),
        ]);
        $myUser->assignRole($myRole);
        $username = 'vcarrillo';
        $myUser = User::create([
            'rut' => '13656451K',
            'username' => $username,
            'first_name' => 'Victor',
            'last_name' => 'Carrillo',
            'email' => $username.'@nipponchile.cl',
            'password' => Hash::make('123456'),
        ]);
        $myUser->assignRole($myRole);

        $myRole = Role::where('name','cont.gen')->first();
        $username = 'dcarcamo';
        $myUser = User::create([
            'rut' => '108120347',
            'username' => $username,
            'first_name' => 'David',
            'last_name' => 'Carcamo',
            'email' => $username.'@nipponchile.cl',
            'password' => Hash::make('123456'),
        ]);
        $myUser->assignRole($myRole);

        $myRole = Role::where('name','adm.gen')->first();
        $username = 'calvarez';
        $myUser = User::create([
            'rut' => '1234567890',
            'username' => $username,
            'first_name' => 'Claudio',
            'last_name' => 'Alvarez',
            'email' => $username.'@nipponchile.cl',
            'password' => Hash::make('123456'),
        ]);
        $myUser->assignRole($myRole);
    }
}
