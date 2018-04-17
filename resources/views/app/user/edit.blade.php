@extends('layouts.app')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{trans('labels.editUser')}}</div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{route('users.update',[$user->id]) }}">
            {{ method_field('PUT') }}
            {!! csrf_field() !!}
            @include('layouts.form.textbox',fData('username',$user->username,[],false))
            @include('layouts.form.textbox',fData('rut',$user->rut))
            @include('layouts.form.textbox',fData('first_name',$user->first_name))
            @include('layouts.form.textbox',fData('last_name',$user->last_name))
            @include('layouts.form.textbox',fData('email',$user->email))
            @include('layouts.form.select',fData('rol_id_user',$user->roles[0]->id,$roles))
            @include('layouts.form.submit',fData('edit'))
        </form>
    </div>
</div>
@endsection