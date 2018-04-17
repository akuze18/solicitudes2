@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{trans('labels.newArea')}}</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('areas.store') }}">
            {!! csrf_field() !!}
            @include('layouts.form.textbox',fData('name',null,[],true,100))
            @include('layouts.form.textbox',fData('sname',null,[],true,20))
            @include('layouts.form.select',fData('area-rank1',null,$roles,true,20))
            @include('layouts.form.select',fData('area-rank2',null,$roles,true,20))
            @include('layouts.form.select',fData('area-rank3',null,$roles,true,20))
            @include('layouts.form.submit',fData('toCreate'))
        </form>
    </div>
</div>
@endsection