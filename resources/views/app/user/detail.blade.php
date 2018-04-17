@extends('layouts.app')
@section('content')
    <h2>{{trans('titles.user.detail')}}: {{$user->name}}</h2>
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('model.user.rol.name')}}</span>
            @foreach($user->roles as $rol)
                <span class="col-md-6">{{$rol->namefull}}</span>
            @endforeach
        </li>
        @foreach($user->getFillable()  as $campo)
            @if($campo!='password' and $campo !='rol_id')
            <li class="list-group-item row">
                <span class="label label-info col-md-2 col-md-offset-1">{{trans('model.user.'.$campo)}}</span>
                <span class="col-md-6">@if($campo=='rut'){{$user->rutStyle}}@else{{$user[$campo]}}@endif</span>
            </li>
            @endif
        @endforeach
    </ul>
    <a href="{{route('users')}}"><span class="label label-success">{{trans('labels.seeAllUsers')}}</span></a>
@endsection