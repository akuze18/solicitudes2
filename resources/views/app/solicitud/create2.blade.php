@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{trans('labels.newSolicitude')}}</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{route('solicitude.store2')}}">
            {!! csrf_field() !!}
            @include('layouts.form.hidden',fData('ref_id',$ref_id))
            @include('layouts.form.hidden',fData('solicitude_id',$bId))
            @include('layouts.form.textbox',fData('user',actualUser()->name,[],false))
            @include('layouts.form.hidden',fData('solType_id',$tipo_solicitud->id))
            @include('layouts.form.textbox',fData('solType_id',$tipo_solicitud->name,[],false))
            @include('layouts.form.hidden',fData('action',$action->id))
            @include('layouts.form.textbox',fData('action',$action->name,[],false))
            @foreach($tipo_solicitud->campos as $field)
                @include('layouts.form.'.$field->type_field,fData('fDy.'.$field->name_field,$reference[$field->name_field],$field->formatLists,true,$field->long_field))
            @endforeach
            @include('layouts.form.textarea',fData('comments',$reference['comments'],[],true,150))
            @include('layouts.form.submit',fData('next'))
        </form>
    </div>
    <div class="panel-footer"><a href="{{route('solicitudes','ESPERA')}}" class="btn btn-success btn-xs">{{trans('labels.seeAllSolicitude')}}</a> </div>
</div>
@endsection

@section('extra_js')

@endsection