<?php

namespace App\Http\Controllers;

use App\Models\Approbation;
use App\Models\ApprobationAction;
use App\Models\ApprobationFormat;
use App\Models\Estado;
use App\Models\FormatList;
use App\Repositories\EstadoRepository;
use App\Models\solicitudAction;
use App\Models\solicitudBatch;
use App\Models\solicitudDetail;
use App\Models\solicitudDetailField;
use App\Models\solicitudFormat;
use App\Models\solicitudType;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Ultraware\Roles\Models\Role;

class SolicitudeController extends Controller
{
    private $estados;

    public function __construct(EstadoRepository $estadoR){
        $this->middleware('auth');
        $this->estados = $estadoR;
    }

    public function index(Request $request,$estado)
    {
        $mySolicitudes = solicitudBatch::MySolicitud($estado)->paginate(20);
        $nuevo = $request->get('new');
        $objetado = $this->estados->Objetado();
        $OEstado = $this->estados->SolEstado($estado);

        /*foreach($mySolicitudes as $solicitude){
            dd($solicitude->status($estado));
        }*/
        return view('app.solicitud.list',compact('mySolicitudes','nuevo','estado','objetado','OEstado'));
    }

    public function create(Request $request, solicitudBatch $batch){
        if(is_null($batch->id)){
            $bId = '';
        }else{
            $bId = $batch->id;
        }
        $old = $request->get('old');
        $solType =  solicitudType::orderBy('orderBy')->get();
        return view('app.solicitud.create',compact('solType','bId','old'));
    }
    public function create2(Request $request, $tipo_sol,$action,solicitudBatch $batch){
        if(is_null($batch->id)){
            $bId = '';
        }else{
            $bId = $batch->id;
        }
        $tipo_solicitud = solicitudType::where('id',$tipo_sol)->first();
        $reference_solicitud = solicitudDetail::where('id',$request->get('old'))->first();
        $reference = [];
        foreach($tipo_solicitud->campos as $format){
            $reference = array_add($reference,$format->name_field,null);
        }
        //dd($reference);
        //dd($reference_solicitud->fields);
        if(!is_null($reference_solicitud)){
            $ref_id = $reference_solicitud->id;
            foreach($reference_solicitud->fields as $field){
                if($field->format->type_field=='select'){
                    //obtengo el texto del tipo de campo
                    $format = FormatList::where('id',$field->value_field)->first();
                    $valor = $format->value;
                    $actualFormat = FormatList::select('format_list.*')
                        ->join('solicitudes_format','solicitudes_format.id','=','format_list.format_id')
                        ->where('value',$valor)
                        ->where('solicitudes_format.solicitude_type_id',$tipo_solicitud->id)
                        ->where('solicitudes_format.name_field',$field->format->name_field)
                        ->first();
                    if(!is_null($actualFormat)) {
                        $actualValue = $actualFormat->id;
                    }
                    else{
                        $actualValue = null;
                    }
                }
                else{
                    $actualValue =$field->value_field;
                }
                $reference[$field->format->name_field] =$actualValue;
            }
            $reference = array_add($reference,'comments',$reference_solicitud->comments);
        }
        else{
            $ref_id = null;
            $reference = array_add($reference,'comments','');
        }

        //$fields = $tipo_solicitud->campos;
        //$list = $tipo_solicitud->list;

        foreach($tipo_solicitud->actions as $elemento){
            if($elemento->code == $action){
                $action=$elemento;
            }
        }
        //dd($reference);
        return view('app.solicitud.create2',compact('bId','tipo_solicitud','action','reference','ref_id'));
    }

    public function store(Request $request)
    {
        $tiposSol = solicitudType::all()->pluck('id');
        //dd($request->get('solType_id'));
        $actionsType = solicitudAction::where('type',$request->get('solType_id'))->get()->pluck('id');
        $tiposVal = implode(",",$tiposSol->all());
        $actionsVal = implode(",",$actionsType->all());
        //dd($actionsVal);
        $rules = [
            'solType_id' => ['required','in:'.$tiposVal,'numeric'],
            'action' => ['required','in:'.$actionsVal],
            'solicitude_id'=>'numeric',
            'old'=>'numeric'
        ];
        $this->validate($request,$rules);
        $data=$request->all();
        $action = solicitudAction::where('id',$data['action'])->first();
        //dd(route('solicitude.create2',[$data['solType_id'],$data['action'],$data['solicitude_id']]));
        $pass = [
            $data['solType_id'],
            $action->code,
            $data['solicitude_id']
        ];
        if($data['old']<>null){
            $pass = array_add($pass,'old',$data['old']);
        }
        return redirect()->route('solicitude.create2',$pass);
    }
    public function store2(Request $request)
    {
        $tiposSol = solicitudType::all()->pluck('id');
        $actionsType = solicitudAction::where('type',$request->get('solType_id'))->get()->pluck('id');
        $tiposVal = implode(",",$tiposSol->all());
        $actionsVal = implode(",",$actionsType->all());
        $rules = [
            'solType_id' => ['required','in:'.$tiposVal,'numeric'],
            'action' => ['required','in:'.$actionsVal],
            'solicitude_id'=>'numeric',
            'ref_id'=>'numeric'
        ];
        $this->validate($request,$rules);
        $data=$request->all();
        //Obtengo tipo de solicitud para validar campos
        $Tipo = solicitudType::where('id',$data['solType_id'])->first();
        foreach($Tipo->field_format as $single){
            $value = 'fDy_'.$single->name_field;
            $newRule = 'max:'.$single->long_field.($single->required ? '|required':'');
            $rules = array_add($rules,$value,$newRule);
        }
        $rules = array_add($rules,'comments','max:150');
        $this->validate($request,$rules);


        //Recupero numero del set si corresponde o creo uno nuevo
        if($data['solicitude_id']==""){
            $Batch = solicitudBatch::create([
                'user_id'=>actualUser()->id,
                'estado'=>'ESPERA',
            ]);
        }else{
            $Batch = solicitudBatch::where('id',$data['solicitude_id'])->first();
        }
        $estadoE = Estado::where('solicitude','ESPERA')->first();
        $headDetail = solicitudDetail::create([
            'solicitude_id'=>$Batch->id,
            'action'=>$data['action'],
            'estado_id'=>$estadoE->id,
            'type_id'=>$Tipo->id,
            'comments'=>$data['comments']
        ]);
        if($data['ref_id']){
            $headDetail->reference = $data['ref_id'];
            $oldDetail = solicitudDetail::where('id',$data['ref_id'])->first();
            $rechazo = ApprobationAction::where('description','Rechazar')->first();
            $oldApprobationRechazo = $oldDetail->approbations()->where('action_id', $rechazo->id)->first();
            $headDetail->observation = $oldApprobationRechazo->observation;
            $headDetail->save();
        }

        $dynamics = array_where($data,function($key,$value){
            return substr($key,0,strlen('fDy'))=='fDy';
        });
        $keys = array_keys($dynamics); //list($keys, $values) = array_divide($dynamics);
        foreach($keys as $key){
            $name_field = substr($key,strlen('fDy')+1); //le quito prefijo identificador
            $campo = solicitudFormat::where('name_field',$name_field)
                ->where('solicitude_type_id',$headDetail->type->id)
                ->first();
            solicitudDetailField::create([
                'solicitude_detail_id'=>$headDetail->id,
                'format_field'=>$campo->id,
                'value_field'=>$dynamics[$key]
            ]);
        }
        return redirect()->route('solicitudes',[$headDetail->estado->solicitude,'new'=>$Batch->id]);
    }

    public function show($estado,solicitudBatch $mySolicitud){
        $objetado = $this->estados->Objetado();
        return view('app.solicitud.detail',compact('mySolicitud','estado','objetado'));
    }

    public function edit(solicitudDetail $detail)
    {
        $tipo_solicitud = $detail->type;
        $action = $detail->actionObj;
        return view('app.solicitud.edit',compact('detail','tipo_solicitud','action'));
    }

    public function update(Request $request, solicitudDetail $detail)
    {
        //Valido que el parametro de la URL previa corresponda al que se quiere modificar
        $previous = URL::previous();
        $last = strrpos($previous,'/');
        $dif = strlen($previous)-$last -1;
        $id_prev = substr($previous,-$dif);
        if($id_prev!=$detail->id){
            return redirect()->back();
        }
        $rules = [];
        $data=$request->all();
        //Obtengo tipo de solicitud para validar campos
        foreach($detail->type->field_format as $single){
            $value = 'fDy_'.$single->name_field;
            $newRule = 'max:'.$single->long_field.($single->required ? '|required':'');
            $rules = array_add($rules,$value,$newRule);
        }
        $rules = array_add($rules,'comments','max:150');
        $this->validate($request,$rules);

        $detail->comments = $data['comments'];
        $detail->save();
        $dynamics = array_where($data,function($key,$value){
            return substr($key,0,strlen('fDy'))=='fDy';
        });
        $keys = array_keys($dynamics); //list($keys, $values) = array_divide($dynamics);
        foreach($keys as $key){
            $name_field = substr($key,strlen('fDy')+1); //le quito prefijo identificador
            $campo = solicitudFormat::where('name_field',$name_field)
                ->where('solicitude_type_id',$detail->type->id)
                ->first();
            $field = solicitudDetailField::where('solicitude_detail_id',$detail->id)
                ->where('format_field',$campo->id)
                ->first();
            $field->value_field = $dynamics[$key];
            $field->save();
        }

        return redirect()->route('solicitude',[$detail->estado->solicitude,$detail->batch->id]);
    }

    public function destroyDetail(solicitudDetail $detail){
        //Valido que el parametro de la URL previa corresponda al que se quiere modificar
        $previous = URL::previous();
        $last = strrpos($previous,'/');
        $dif = strlen($previous)-$last -1;
        $id_prev = substr($previous,-$dif);
        if($id_prev!=$detail->batch->id){
            return redirect()->back();
        }
        $batch = $detail->batch;
        $detail->delete();

        return redirect()->route('solicitude',['ESPERA',$batch->id]);
    }
    public function destroyBatch(solicitudBatch $batch){
        //Luego elimino el batch asociado
        $batch->delete();
        return redirect()->route('solicitudes',['ESPERA']);
    }

  /*
    public function generate(solicitudBatch $batch){
        //Validar que batch sea propio
        if($batch->user->id != auth()->user()->id){
            return redirect()->back();
        }
        //Validar composicion del Batch
        //Enviar Batch para aprobar
        $enviado = $this->estados->Enviado();
        $pendiente = $this->estados->Espera();
        //dd($enviado->name);
        foreach($batch->status($pendiente->solicitude) as $detail){
            $detail->estado_id = $enviado->id;
            $detail->save();
            //obtengo el formato segun el tipo de solicitud
            $formatsAprob = ApprobationFormat::where('solicitude_type_id',$detail->type->id)->get();
            $wait = false;
            foreach($formatsAprob as $singleFormat) {
                //determinar approver segun su pattern
                $pattern = explode('.', $singleFormat->pattern_approver);
                if ($pattern[0] == 'area') {
                    $roles = $batch->user->roles;
                    //dd($roles[0]->area);
                    if ($pattern[1] == 'rank1') {
                        $approver_rol = $roles[0]->area->rank1;
                    }elseif ($pattern[1] == 'rank2') {
                        $approver_rol = $roles[0]->area->rank2;
                    }else {
                        $approver_rol = $roles[0]->area->rank3;
                    }
                } else {
                    $approver_rol = $pattern[0] . '.' . $pattern[1];
                }
                $approvers = Role::where('slug', $approver_rol)->first();
                $approver_user = $approvers->users[0];
                //determinar acción según si tiene que esperar aprobación o no
                if($wait){
                    $action = ApprobationAction::where('description','Esperar')->first();
                }
                else{
                    $action = ApprobationAction::where('description','Pendiente')->first();
                }
                $wait = $singleFormat->wait;
                $prevApprobation = Approbation::where('solicitude_detail_id', $detail->id)
                    ->where('approver_id', $approver_user->id)
                    ->first();
                if (count($prevApprobation) == 0) {
                    //no existe una aprobacion previa para la misma solicitud y aprobador
                    $newApprobation = Approbation::create([
                        'solicitude_detail_id' => $detail->id,
                        'solicitude_batch_id' => $detail->batch->id,
                        'order' => $singleFormat->order,
                        'action_id' => $action->id,
                        'format_id' => $singleFormat->id,
                        'approver_id' => $approver_user->id,
                        'observation' => ''
                    ]);
                }
                else{

                    if($prevApprobation->action->description=='Objetar'){
                        $action = ApprobationAction::where('description','Pendiente')->first();
                        $prevApprobation->action_id = $action->id;
                        $prevApprobation->observation = '';
                        $prevApprobation->save();
                    }
                }
            }
        }
        //$batch->estado = '';
        //$batch->save();
        return redirect()->route('solicitudes',[$enviado->solicitude,'new'=>$batch->id]);
    }
*/

    public function getAction(Request $request){
        $elements = '';
        $data = $request->all();
        $typeSol = $data['typeSol'];
        if($typeSol!='') {
            $solType = solicitudType::where('id', $typeSol)->first();
            $elements = '<option selected disabled></option>';
            foreach ($solType->actions as $lista) {
                $elements = $elements . '<option value="' . $lista->id . '">' . $lista->name . '</option>';
            }
        }
        return $elements;
    }
    public function getApprobationStatus(Request $request){
        $detail_id = $request->get('detail_id');
        $detail = solicitudDetail::where('id',$detail_id)->first();
        $contenido = '';
        foreach($detail->approbations as $approbation){
            switch($approbation->action->id){
                case 1: //Aprobado
                    $class = 'label label-success';
                    $class2 = 'alert alert-success';
                    break;
                case 2: //Objetado
                    $class = 'label label-warning';
                    $class2 = 'alert alert-warning';
                    break;
                case 3: //Rechazado
                    $class = 'label label-danger';
                    $class2 = 'alert alert-danger';
                    break;
                case 4: //Pendiente
                    $class = 'label label-info';
                    $class2 = 'alert alert-info';
                    break;
                default: //a la espera
                    $class = 'label label-default';
                    $class2 = 'alert alert-default';
                    break;
            }
            $value = '<span class="'.$class.'">'.$approbation->action->estado->approbation.'</span>';
            $linea = $approbation->order.') '.$approbation->approver->name.' : '.$value;
            $contenido .= '<p>'.$linea.'</p>';
            if($approbation->observation<>''){
                $contenido .= '<div class="'.$class2.'">'.$approbation->observation.'</div>';
            }
        }
        return $contenido;
    }
}
