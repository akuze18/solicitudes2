@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{trans('labels.editArea')}}</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('areas.update',$area->id) }}">
            {{ method_field('PUT') }}
            {!! csrf_field() !!}
            @include('layouts.form.textbox',fData('name',$area->name,[],true,100))
            @include('layouts.form.textbox',fData('sname',$area->sname,[],true,20))
            @include('layouts.form.select',fData('area-rank1',$area->RangoId($area->rank1),$roles,true,20))
            @include('layouts.form.select',fData('area-rank2',$area->RangoId($area->rank2),$roles,true,20))
            @include('layouts.form.select',fData('area-rank3',$area->RangoId($area->rank3),$roles,true,20))
            @include('layouts.form.submit',fData('edit'))
        </form>
    </div>
</div>
@endsection