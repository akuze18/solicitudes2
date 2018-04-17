@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{trans('titles.solicitudeType.edit')}}</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{route('solicitudeType.update',$solicitudType->id)}}">
            {!! csrf_field() !!}
            {{ method_field('PUT') }}
            @include('layouts.form.textbox',fData('solType_cod',$solicitudType->id,[],false))
            @include('layouts.form.textbox',fData('name',$solicitudType->name,[],true))
            @include('layouts.form.numberbox',fData('orderBy',$solicitudType->orderBy,$solicitudType,true))
            @include('layouts.form.displaylist',fData('actions',null,$solicitudType->actions))
            @include('layouts.form.submit',fData('save'))
        </form>
    </div>
    <div class="panel-footer"><a href="{{route('solicitudeTypes')}}" class="btn btn-success btn-xs">{{trans('labels.seeAllSolicitudeType')}}</a> </div>
</div>
@endsection

@section('extra_js')

@endsection