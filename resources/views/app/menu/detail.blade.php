@extends('layouts.app')
@section('content')
    <h2>{{trans('titles.menu.detail')}}: {{$menu->contain}}</h2>
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.header')}}</span>
            <span class="col-md-6">{{$menu->header}}</span>
        </li>
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.route')}}</span>
            <span class="col-md-6">{{route($menu->route,$menu->parameters)}}</span>
        </li>
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.icon')}}</span>
            <span class="col-md-6"><span class="glyphicon {{$menu->icon_name}}" aria-hidden="true"></span></span>
        </li>
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.permission')}}</span>
            <span class="col-md-6">{{$menu->permission}}</span>
        </li>
        <li class="list-group-item row">
            <span class="label label-primary col-md-2">{{trans('labels.orderBy')}}</span>
            <span class="col-md-6">{{$menu->orderBy}}</span>
        </li>
    </ul>
    <a href="{{route('menus')}}" class="btn btn-success btn-xs">{{trans('labels.seeAllMenu')}}</a>
@endsection