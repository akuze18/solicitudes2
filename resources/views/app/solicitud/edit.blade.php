@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{trans('labels.editSolicitude')}}</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{route('solicitude.update',$detail->id)}}">
            {!! csrf_field() !!}
            {{ method_field('PUT') }}
            @include('layouts.form.textbox',fData('user',actualUser()->name,[],false))
            @include('layouts.form.textbox',fData('solType_id',$tipo_solicitud->name,[],false))
            @include('layouts.form.textbox',fData('action',$action->name,[],false))
            @foreach($tipo_solicitud->campos as $field)
                <?php $valor_actual = $detail->fields->where('format_field',$field->id)->first(); ?>
                @include('layouts.form.'.$field->type_field,fData('fDy.'.$field->name_field,$valor_actual->value_field,$field->formatLists,true,$field->long_field))
            @endforeach
            @include('layouts.form.textarea',fData('comments',$detail->comments,[],true,150))
            @include('layouts.form.submit',fData('next'))
        </form>
    </div>
    <div class="panel-footer"><a href="{{route('solicitudes',[$detail->estado->solicitude])}}" class="btn btn-success btn-xs">{{trans('labels.seeAllSolicitude')}}</a> </div>
</div>
@endsection

@section('extra_js')

@endsection