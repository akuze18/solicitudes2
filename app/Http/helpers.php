<?php
use App\Models\Menu;
use App\Models\solicitudFormat;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

/**
 * @return \App\Models\User|null
 */
function actualUser(){
    return auth()->user();
}

function fData($eName,$eVal=null,$elements=[],$enable=true,$len=null)
{

    if ( !is_null($eVal) and count($eVal)==0  and count($elements)>0 ) {
        $existe = false;
        foreach ($elements as $element) {
            if ($element->id == $eVal) {
                $existe = true;
            }
        }
        if (!$existe) {
            $eVal = null;
        }
    }
    $groups = [];
    //echo gettype($elements);
    if(gettype($elements)=='object'){
        $cl = (get_class($elements));
        //echo $cl;
        $obj = new $cl();
        if($cl=='Illuminate\Database\Eloquent\Collection'){
            $def_grupos = true;
        }
        else{
            $def_grupos = false;
            if (!is_int($len)) {
                $len = 0;
            }
            if(is_a($obj,'App\Models\solicitudAction')) {
                $len += count($obj::where('type', $elements->type)->all());
            }
            else {
                $len += count($obj->all());
            }
        }
    }
    else{
        $def_grupos = true;
    }


    if($def_grupos){
        foreach($elements as $element){
            //$cl = (get_class($element));
            if(!is_null($element->group)){
                if(!in_array($element->group,$groups)){
                    $groups = array_add($groups,$element->group,[]);
                }
                array_push($groups[$element->group],$element);
            }
            else{
                if(!in_array('',$groups)){
                    $groups = array_add($groups,'',[]);
                }
                array_push($groups[''],$element);
            }
        }
    }


    $vars =  [
        'eName'=>str_replace('.','_',$eName),
        'eLabel'=>$eName,
        'eVal'=>$eVal,
        'elements'=>$elements,
        'enable'=>$enable,
        'len'=>$len,
        'groups' => $groups
    ];

    return $vars;
}

function define_dynamics_labels(){
    $dynamic = [];
    $formats = solicitudFormat::all();
    foreach($formats as $format){
        $key = $format->name_field;
        $value = $format->name_display;
        $dynamic=array_add($dynamic,$key,$value);
    }
    return $dynamic;
}

function define_menu(){
    $menus = Menu::orderBy('orderBy')->get();
    $grants = [];
    $header = '';
    foreach($menus as $menu){
        $sper = Permission::where('name',$menu->permission)->first();
        if(actualUser()->hasPermissionTo($sper)){
            $actualHeader = str_replace('.','',$menu->header);
            if($header != $menu->header){
                $grants = array_add($grants,$actualHeader,[]);
                $header=$menu->header;
            }
            array_push($grants[$actualHeader],$menu);
        }
    }
    return $grants;
}

/**
 * @param bool $lower
 * @return array
 */
function define_labels($lower = false)
{
    $labels = [
        'password' => 'Contraseña',
        'password_confirmation' => 'Confirme Contraseña',
        'rol_id_user' => 'Rol de Usuario',
        'toRegister' => 'Registrar',
        'toCreate' => 'Crear',
        'toDelete' => 'Borrar',
        'toSend' => 'Enviar',
        'toReject' => 'Rechazar',
        'toObject' => 'Objectar',
        'add' => 'Agregar',
        'addNew' => 'Agregar Nuevo',
        'edit' => 'Modificar',
        'save' => 'Guardar',
        'userRegister' => 'Registro de Usuario',
        'area' => 'Area',
        'area-rank1' => 'Rango 1',
        'area-rank2' => 'Rango 2',
        'area-rank3' => 'Rango 3',
        'special.rank' => 'Cargos Especiales',
        'member' => 'Miembro',
        'seeAllRol' => 'Volver a todos los roles',
        'seeAllArea' => 'Volver a todas las areas',
        'seeAllUsers' => 'Volver a todos los usuarios',
        'seeAllPermission' => 'Volver a todos los permisos',
        'seeAllSolicitude' => 'Volver a todas las solicitudes',
        'seeAllApprobation' => 'Volver a todas las aprobaciones',
        'seeAllSolicitudeType' => 'Volver a todos los tipos de solicitudes',
        'seeAllMenu' => 'Volver a todos los menus',
        'seeDetail' => 'Ver detalle',
        'name' => 'Nombre',
        'sname' => 'Nombre Corto',
        'first_name' => 'Nombre',
        'last_name' => 'Apellido',
        'email' => 'Correo Electrónico',
        'actions' => 'Acciones',
        'estado' => 'Estado',
        'rol' => 'Rol',
        'username' => 'Nombre de Usuario',
        'newArea' => 'Ingreso de Area',
        'newRole' => 'Ingreso de Rol',
        'newPermission' => 'Ingreso de Permiso',
        'newSolicitude' => 'Ingreso de Solicitud',
        'editArea' => 'Modificar Area',
        'editRole' => 'Modificar Rol',
        'editUser' => 'Modificar Usuario',
        'editPermission' => 'Modificar Permiso',
        'editPermissions' => 'Modificar Permisos',
        'editSolicitude' => 'Modificar Solicitud',
        'area_id_rol' => 'Area del Rol',
        'rut' => 'RUT',
        'description' => 'Descripción',
        'rol_id_permission' => 'Rol de Permiso',
        'permission_id_rol' => 'Permisos del Rol',
        'permissions' => 'Permisos',
        'permission' => 'Permiso',
        'slug' => 'Codigo',
        'solType_id' => 'Tipo de Solicitud',
        'solType_cod' => 'Codigo de Tipo',
        'solType_name' => 'Nombre de Tipo',
        'action' => 'Acción',
        'next' => 'Siguiente',
        'user' => 'Usuario',
        'type_id' => 'Tipo',
        'comments' => 'Comentarios',
        'accept' => 'Aceptar',
        'orderBy' => 'Posición',
        'icon' => 'Icono',
        'route' => 'Ruta',
        'header' => 'Cabecera',
        'fields' => 'Campos',
        'field' => 'Campo',
        'type' => 'Tipo',
        'maxLen' => 'Largo Maximo',
        'required' => 'Requerido',
        'title' => 'en Titulo',
        'detail' => 'Detalle',
        'login' => 'Entrar',
        'remember' => 'Recordarme en este equipo',
        '' => '',
    ];
    if ($lower) {
        foreach ($labels as $clave => $valor) {
            if($clave!='rut'){
                $labels[$clave] = strtolower($valor);
            }
        }
        //Para campos dinamicos del programa
        foreach(define_dynamics_labels() as $key => $value){
            $labels = array_add($labels,'fDy_'.$key,strtolower($value));
        }
    }
    else{
        //Para campos dinamicos del programa
        $labels = array_add($labels,'fDy',define_dynamics_labels());
    }
    return $labels;
}

function previous_segment(Request $request){
    $lastUrl =  $request->session()->previousUrl();
    $path = parse_url($lastUrl)['path'];
    $segments = explode('/',$path);
    if($segments[0]==''){
        $segments=array_slice($segments,1);
    }
    return $segments;
}

function update_other_orderBy($actOrder,$newOrder,$nameClass){
    if(class_exists($nameClass) ){
        $obj = new $nameClass();
        if($actOrder!=$newOrder){
            if($actOrder>$newOrder){
                $others = $obj::where('orderBy','>=',$newOrder)
                    ->where('orderBy','<',$actOrder)
                    ->get();
                foreach($others as $other){
                    $other->timestamps = false;
                    $other->orderBy = $other->orderBy+1;
                    $other->save();
                }
            }
            else{
                $others = $obj::where('orderBy','>',$actOrder)
                    ->where('orderBy','<=',$newOrder)
                    ->get();
                foreach($others as $other){
                    $other->timestamps = false;
                    $other->orderBy = $other->orderBy-1;
                    $other->save();
                }
            }
        }
    }
}