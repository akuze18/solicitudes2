@extends('layouts.app')
@section('content')
    <h2>{{trans('titles.role.detail')}}: {{$rol->name}}</h2>
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.area')}}</span>
            <span class="col-md-6">{{$rol->area->name}}</span>
        </li>
        @foreach($rol->users  as $user)
        <li class="list-group-item row">
            <span class="label label-info col-md-2 col-md-offset-1">{{trans('labels.member')}}</span>
            <span class="col-md-6">{{$user->name}}</span>
        </li>
        @endforeach
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.permissions')}}</span>
        </li>
        @foreach($rol->permissions  as $permission)
            <li class="list-group-item row">
                <span class="label label-warning col-md-2 col-md-offset-1">{{trans('labels.permission')}}</span>
                <span class="col-md-6">{{$permission->name}}</span>
            </li>
        @endforeach
    </ul>
    <a href="{{route('roles')}}" class="btn btn-success btn-xs">{{trans('labels.seeAllRol')}}</a>
@endsection