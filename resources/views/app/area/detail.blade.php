@extends('layouts.app')
@section('content')
    <h2>{{trans('titles.area.detail')}}: {{$area->name}}</h2>
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.area')}}</span>
            <span class="col-md-6">{{$area->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.sname')}}</span>
            <span class="col-md-6">{{$area->sname}}</span>
        </li>
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('titles.role.list')}}</span>
            <span class="col-md-6">Contiene {{$area->roles->count()}}</span>
        </li>
        @foreach($area->roles  as $role)
        <li class="list-group-item row">
            <span class="label label-info col-md-2 col-md-offset-1">{{trans('labels.rol')}}</span>
            <span class="col-md-6">{{$role->name}}</span>
        </li>
        @endforeach
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.special.rank')}}</span>
        </li>
        <li class="list-group-item row">
            <span class="label label-info col-md-2 col-md-offset-1">{{trans('labels.area-rank1')}}</span>
            <span class="col-md-6">{{$area->rango1}}</span>
        </li>
        <li class="list-group-item row">
            <span class="label label-info col-md-2 col-md-offset-1">{{trans('labels.area-rank2')}}</span>
            <span class="col-md-6">{{$area->rango2}}</span>
        </li>
        <li class="list-group-item row">
            <span class="label label-info col-md-2 col-md-offset-1">{{trans('labels.area-rank3')}}</span>
            <span class="col-md-6">{{$area->rango3}}</span>
        </li>
    </ul>
    <a href="{{route('areas')}}" class="btn btn-success btn-xs">{{trans('labels.seeAllArea')}}</a>

@endsection