@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{trans('labels.editPermission')}}</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('permissions.update',$permission->id) }}">
            {{ method_field('PUT') }}
            {!! csrf_field() !!}
            @include('layouts.form.textbox',fData('name',$permission->name,[],false))
            @include('layouts.form.checklist',fData('rol_id_permission',$permission->roles,$roles))
            @include('layouts.form.submit',fData('edit'))
        </form>
    </div>
    <div class="panel-footer"><a href="{{route('permissions')}}" class="btn btn-success btn-xs">{{trans('labels.seeAllPermission')}}</a></div>
</div>
@endsection