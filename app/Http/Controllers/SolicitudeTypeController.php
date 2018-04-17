<?php

namespace App\Http\Controllers;

use App\Models\FormatList;
use App\Repositories\AllRepositories;
use App\Models\solicitudFormat;
use App\Models\solicitudType;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SolicitudeTypeController extends Controller
{
    private $reps;
    public function __construct(AllRepositories $repositories){
        $this->reps = $repositories;
    }

    public function index()
    {
        $types = $this->reps->solType()->listType();
        return view('app.solicitud.type.list',compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = $this->reps->solType()->byId($id);
        return view('app.solicitud.type.detail',compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $solicitudType = solicitudType::where('id',$id)->firstOrFail();
        return view('app.solicitud.type.edit',compact('solicitudType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $sol_type_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sol_type_id)
    {
        $lsegm = previous_segment($request);
        //$segmentos = $request->segments();        //de la actual URL
        $maxSol = solicitudType::all()->count();
        $rules = [
            'name'=>'required',
            'orderBy'=>['required','integer','digits_between:1,'.$maxSol]
        ];
        if($lsegm[2]!=$sol_type_id){
            $rules = array_add($rules,'solType_cod','required');    //esto generar un error en la vista
        }
        $this->validate($request,$rules);
        $data = $request->all();
        //guardo nombre en la BD
        $solicitudType = solicitudType::where('id',$sol_type_id)->first();
        $solicitudType->name = $data['name'];
        $solicitudType->save();
        //actualizo la posición (debo modificar la posicion de otros registros)
        $actOrder = $solicitudType->orderBy;
        $newOrder = $data['orderBy'];
        if($actOrder!=$newOrder){
            update_other_orderBy($actOrder,$newOrder,get_class($solicitudType));
            $solicitudType->orderBy = $newOrder;
            $solicitudType->save();
        }
        return redirect()->route('solicitudeTypes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //AJAX
    public function getFormatList(Request $request){
        $field_id = $request->get('field_id');
        $campo = solicitudFormat::where('id',$field_id)->first();
        $formatLists = $campo->formatLists;

        $lists = '<ul class="list-group"><li class="list-group-item row">
                <span class="label label-warning col-md-2">'.trans('labels.field').'</span>
                <span class="col-md-8">'.$campo->name_display.'</span></li></ul>';

        if($formatLists->count()>0){
            $lists .= '<ul class="list-group">';
            foreach($formatLists as $formatList){
                $lists .= '<li class="list-group-item">'.$formatList->display.'</li>';
            }
            $lists .= '</ul>';
        }

        return $lists;
    }
}
