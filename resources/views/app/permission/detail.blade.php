@extends('layouts.app')
@section('content')
    <h2>{{trans('labels.permission')}}: {{$permission->slug}}</h2>
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.name')}}</span>
            <span class="col-md-6">{{$permission->name}}</span>
        </li>
        @foreach($permission->roles as $rol)
            <li class="list-group-item row">
                <span class="label label-warning col-md-2">{{trans('labels.rol')}}</span>
                <span class="col-md-6">{{$rol->Namefull}}</span>
            </li>
        @endforeach
    </ul>
    <a href="{{route('permissions')}}" class="btn btn-success btn-xs">{{trans('labels.seeAllPermission')}}</a>
@endsection