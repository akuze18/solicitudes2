<?php

namespace App\Http\Controllers;

use App\Models\Approbation;
use App\Models\ApprobationAction;
use App\Models\ApprobationFormat;
use App\Repositories\EstadoRepository;
use App\Models\solicitudBatch;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Ultraware\Roles\Models\Role;

class ApprobationController extends Controller
{
    private $estados;

    public function __construct(EstadoRepository $estadoR){
        $this->middleware('auth');
        $this->estados = $estadoR;
    }

    public function index()
    {
        $action = ApprobationAction::where('description','Pendiente')->first();
        $myApprobations = Approbation::select(DB::raw('solicitude_batch_id as batch,count(action_id) as countBatch, sum(case solicitude_details.observation when \'\' then 0 else 1 end ) as Objetado'))
            ->join('solicitude_details','solicitude_details.id',"=","approbations.solicitude_detail_id")
            ->where('approver_id',auth()->user()->id)
            ->where('action_id',$action->id)
            ->groupBy('solicitude_batch_id')
            ->paginate(20);
        //dd($myApprobations);
        return view('app.approbation.list',compact('myApprobations','action'));
    }

    public function store(solicitudBatch $batch)
    {
        //Validar que batch sea propio
        if($batch->user->id != actualUser()->id){
            return redirect()->back();
        }
        //TODO Validar composicion del Batch
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

    public function show($batch_id){
        $action = ApprobationAction::where('description','Pendiente')->first();
        $details =  Approbation::where('solicitude_batch_id',$batch_id)
            ->where('approver_id',auth()->user()->id)
            ->where('action_id',$action->id)
            ->get();
        return view('app.approbation.detail',compact('details'));
    }

    public function update(Request $request)
    {
        $rules = [
            'approbation_id'=>['required'],
            'action_id'=>['required','in:Accept,Reject,Object']
        ];
        $this->validate($request,$rules);
        if($request->get('action_id')<>'Accept'){
            $this->validate($request,['observation'=>'required']);
        }
        $data = ($request->all());
        $approbation = Approbation::where('id',$data['approbation_id'])->first();
        switch($data['action_id']){
            case 'Accept':
                $action = ApprobationAction::where('description','Aprobar')->first();
                $observation = '';
                $solicitud = $approbation->solicitud;
                $solicitud->observation = $observation;
                $solicitud->save();
                //marco el siguiente como en espera
                $nextApprobations = Approbation::where('solicitude_detail_id',$approbation->solicitude_detail_id)
                    ->where('order','>',($approbation->order))
                    ->get();
                $wait = false;
                if($nextApprobations->count()>0) {
                    foreach ($nextApprobations as $nextApprobation) {
                        if ($wait) {
                            $nextAction = ApprobationAction::where('description', 'Esperar')->first();
                        } else {
                            $nextAction = ApprobationAction::where('description', 'Pendiente')->first();
                        }
                        $wait = $nextApprobation->formato->wait;
                        $nextApprobation->action_id = $nextAction->id;
                        $nextApprobation->save();
                    }
                }
                else{
                    //No hay siguientes aprobaciones, por lo que ya paso el filtro de aprobaciones
                    //reviso que el resto de la linea de aprobación esté completa
                    $sol_id = $approbation->solicitud->id;
                    $lineApprobations = Approbation::where('solicitude_detail_id',$sol_id)
                        ->where('id','<>',$approbation->id)
                        ->get();
                    $countNoAccept =$lineApprobations->where('action_id','<>',$action->id)->count();
                    if($countNoAccept==0){
                        //all aprobado entonces la solicitud se marca como aprobada
                        $solicitud = $approbation->solicitud;
                        $solicitud->estado_id = $action->status;
                        $solicitud->save();
                    }
                }
                break;
            case 'Reject':
                $action = ApprobationAction::where('description','Rechazar')->first();
                $observation = $data['observation'];
                //con 1 aprobacion rechazada, se marca la solicitud como rechazada
                $solicitud = $approbation->solicitud;
                $solicitud->estado_id = $action->status;
                $solicitud->observation = $observation;
                $solicitud->save();
                break;
            case 'Object':
                $action = ApprobationAction::where('description','Objetar')->first();
                $observation = $data['observation'];
                //con 1 aprobación objetada, se debe marcar solicitud como en trabajo
                $solicitud = $approbation->solicitud;
                $solicitud->estado_id = $action->status;
                $solicitud->observation = $observation;
                $solicitud->save();
                break;
        }
        $approbation->action_id = $action->id;
        $approbation->observation = $observation;
        //$approbation->solicitud->estado = $action->description;
        $approbation->save();
        //dd($action->description);
        return redirect()->route('approbations');
    }
}
