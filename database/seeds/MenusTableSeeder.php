<?php

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [];
    //Solicitudes
        $solicitudes1 = Menu::create([
            'header'=>'Solicitudes',
            'contain'=>'Ver Trabajo',
            'route'=>'solicitudes',
            'icon_name'=>'glyphicon-pushpin',
            'parameter1'=>'ESPERA',
            'parameter2'=>'',
            'permission'=>'list.solicitude'
        ]);
        array_push($options,$solicitudes1);
        $solicitudes2 = Menu::create([
            'header'=>'Solicitudes',
            'contain'=>'Ver Enviadas',
            'route'=>'solicitudes',
            'icon_name'=>'glyphicon-send',
            'parameter1'=>'ENVIADO',
            'parameter2'=>'',
            'permission'=>'list.solicitude'
        ]);
        array_push($options,$solicitudes2);
        $solicitudes3 = Menu::create([
            'header'=>'Solicitudes',
            'contain'=>'Ver Aprobadas',
            'route'=>'solicitudes',
            'icon_name'=>'glyphicon-ok',
            'parameter1'=>'APROBADO',
            'parameter2'=>'',
            'permission'=>'list.solicitude'
        ]);
        array_push($options,$solicitudes3);
        $solicitudes4 = Menu::create([
            'header'=>'Solicitudes',
            'contain'=>'Ver Rechazadas',
            'route'=>'solicitudes',
            'icon_name'=>'glyphicon-remove',
            'parameter1'=>'RECHAZADO',
            'parameter2'=>'',
            'permission'=>'list.solicitude'
        ]);
        array_push($options,$solicitudes4);
    //Aprobaciones
        $approbaciones = Menu::create([
            'header'=>'Aprobaciones',
            'contain'=>'Ver Aprobaciones',
            'route'=>'approbations',
            'icon_name'=>'glyphicon-th',
            'parameter1'=>'',
            'parameter2'=>'',
            'permission'=>'list.approbation'
        ]);
        array_push($options,$approbaciones);
    //Configuraciones Solicitudes
        $confSol1 = Menu::create([
            'header'=>'Config. Solicitudes',
            'contain'=>'Tipos',
            'route'=>'solicitudeTypes',
            'icon_name'=>'glyphicon-th',
            'parameter1'=>'',
            'parameter2'=>'',
            'permission'=>'list.solicitudetype'
        ]);
        array_push($options,$confSol1);
        $confSol2 = Menu::create([
            'header'=>'Config. Solicitudes',
            'contain'=>'Acciones',
            'route'=>'solicitudeActions',
            'icon_name'=>'glyphicon-th',
            'parameter1'=>'',
            'parameter2'=>'',
            'permission'=>'list.solicitudeaction'
        ]);
        array_push($options,$confSol2);
    //Configuraciones Aprobaciones
        $confApprov1 = Menu::create([
            'header'=>'Config. Aprobaciones',
            'contain'=>'Linea de Aprobaciones',
            'route'=>'approbationFormats',
            'icon_name'=>'glyphicon-th',
            'parameter1'=>'',
            'parameter2'=>'',
            'permission'=>'list.approbationformat'
        ]);
        array_push($options,$confApprov1);
    //Sistemas
        $sistema1 = Menu::create([
            'header'=>'Sistema',
            'contain'=>'Areas',
            'route'=>'areas',
            'icon_name'=>'glyphicon-th',
            'parameter1'=>'',
            'parameter2'=>'',
            'permission'=>'list.area'
        ]);
        array_push($options,$sistema1);
        $sistema2 = Menu::create([
            'header'=>'Sistema',
            'contain'=>'Roles',
            'route'=>'roles',
            'icon_name'=>'glyphicon-th',
            'parameter1'=>'',
            'parameter2'=>'',
            'permission'=>'list.role'
        ]);
        array_push($options,$sistema2);
        $sistema3 = Menu::create([
            'header'=>'Sistema',
            'contain'=>'Permisos',
            'route'=>'permissions',
            'icon_name'=>'glyphicon-th',
            'parameter1'=>'',
            'parameter2'=>'',
            'permission'=>'list.permission'
        ]);
        array_push($options,$sistema3);
        $sistema4 = Menu::create([
            'header'=>'Sistema',
            'contain'=>'Usuarios',
            'route'=>'users',
            'icon_name'=>'glyphicon-user',
            'parameter1'=>'',
            'parameter2'=>'',
            'permission'=>'list.user'
        ]);
        array_push($options,$sistema4);
        $sistema5 = Menu::create([
            'header'=>'Sistema',
            'contain'=>'Menus',
            'route'=>'menus',
            'icon_name'=>'glyphicon-menu-hamburger',
            'parameter1'=>'',
            'parameter2'=>'',
            'permission'=>'list.menu'
        ]);
        array_push($options,$sistema5);

        foreach($options as $option){
            $option->orderBy = $option->id;
            $option->save();
        }
    }
}
